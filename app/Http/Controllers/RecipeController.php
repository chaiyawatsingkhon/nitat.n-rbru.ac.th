<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RecipeController extends Controller
{
    // รายการสูตร: ของตัวเอง + สูตรสาธารณะของคนอื่น พร้อมค้นหา/กรอง/แบ่งหน้า
    public function index(Request $request): View
    {
        $userId = $request->user()->id;

        $recipes = Recipe::query()
            ->with(['category', 'cuisine', 'tags'])               // Eager Loading กัน N+1
            ->where(fn ($q) => $q->where('user_id', $userId)->orWhere('is_public', true))
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->integer('category')))
            ->when($request->filled('tag'), fn ($q) => $q->whereHas('tags', fn ($t) => $t->where('tags.id', $request->integer('tag'))))
            ->when($request->boolean('mine'), fn ($q) => $q->where('user_id', $userId))
            ->search($request->input('q'))                        // scopeSearch ใน Model
            ->latest()
            ->paginate(9)
            ->withQueryString();                                  // เก็บตัวกรองไว้ตอนเปลี่ยนหน้า

        return view('recipes.index', [
            'recipes'    => $recipes,
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('recipes.create', $this->formData());
    }

    public function store(RecipeRequest $request): RedirectResponse
    {
        // เอาเฉพาะฟิลด์ของตาราง recipes (ตัด image, tags, remove_image ออก)
        $data = $request->safe()->except(['image', 'tags', 'remove_image']);
        $data['user_id']   = $request->user()->id;
        $data['slug']      = $this->makeSlug($data['title'] ?? $data['name'] ?? 'recipe');
        $data['is_public'] = $request->boolean('is_public');

        // อัปโหลดรูปไปเก็บที่ public/images/
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('images'), $filename);

            $data['image_path'] = $filename;
            $data['image_url']  = $filename;
            $data['image']      = $filename;
        }

        $recipe = Recipe::create($data);

        // บันทึกแท็กลงตารางกลาง recipe_tag (ถ้าไม่เลือกเลยจะเป็น array ว่าง)
        $recipe->tags()->sync($request->input('tags', []));

        return redirect()->route('recipes.show', $recipe)->with('status', 'เพิ่มสูตรอาหารเรียบร้อยแล้ว');
    }

    public function show(Recipe $recipe): View
    {
        Gate::authorize('view', $recipe);   // ตรวจสิทธิ์ผ่าน RecipePolicy

        $recipe->load(['user', 'category', 'cuisine', 'tags']);

        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe): View
    {
        Gate::authorize('update', $recipe);

        $recipe->load('tags');

        return view('recipes.edit', $this->formData() + ['recipe' => $recipe]);
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        Gate::authorize('update', $recipe);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['image', 'tags', 'remove_image']);
        $data['is_public'] = $request->boolean('is_public');

        // อัปเดต slug ถ้ามีการเปลี่ยนชื่อ
        if (!empty($data['title'])) {
            $data['slug'] = $this->makeSlug($data['title']);
        } elseif (!empty($data['name'])) {
            $data['slug'] = $this->makeSlug($data['name']);
        }

        // การจัดการไฟล์รูปภาพ
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            
            // ย้ายไฟล์ไปที่ public/images/
            $file->move(public_path('images'), $filename);

            // เซฟชื่อไฟล์ลงทุกฟิลด์ที่เป็นไปได้ใน DB
            $data['image_path'] = $filename;
            $data['image_url']  = $filename;
            $data['image']      = $filename;
        }

        $recipe->update($data);

        // อัปเดตแท็ก
        if ($request->has('tags')) {
            $recipe->tags()->sync($request->input('tags', []));
        }

        return redirect()->route('recipes.show', $recipe)->with('status', 'อัปเดตข้อมูลและรูปภาพเรียบร้อยแล้ว');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        Gate::authorize('delete', $recipe);

        // Soft delete: ข้อมูลยังอยู่ในฐานข้อมูล (deleted_at) จึงยังไม่ลบไฟล์รูป
        $recipe->delete();

        return redirect()->route('recipes.index')->with('status', 'ลบสูตรอาหารเรียบร้อยแล้ว');
    }

    // ข้อมูลที่ฟอร์ม Create/Edit ต้องใช้ (dropdown และตัวเลือกแท็ก)
    private function formData(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'cuisines'   => Cuisine::orderBy('name')->get(),
            'tags'       => Tag::orderBy('type')->orderBy('name')->get(),
        ];
    }

    // สร้าง slug ที่ไม่ซ้ำ: ชื่อ (ถ้าแปลงเป็นอังกฤษได้) + รหัสสุ่ม 6 ตัว
    // ชื่อภาษาไทยอาจแปลงเป็น slug ไม่ได้ จึงมีค่าสำรองเป็น "recipe"
    private function makeSlug(string $title): string
    {
        $base = Str::limit(Str::slug($title) ?: 'recipe', 120, '');

        return $base . '-' . Str::lower(Str::random(6));
    }
}