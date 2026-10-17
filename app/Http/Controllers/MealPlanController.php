<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealPlanRequest;
use App\Models\MealPlan;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MealPlanController extends Controller
{
    // รายการแผนมื้ออาหารของตัวเอง เรียงจากวันที่ล่าสุด
    public function index(Request $request): View
    {
        $plans = $request->user()->mealPlans()
            ->with('recipes')                 // โหลดสูตรล่วงหน้า เพื่อคำนวณโภชนาการรวม
            ->orderByDesc('plan_date')
            ->paginate(10);

        return view('meal-plans.index', compact('plans'));
    }

    public function create(Request $request): View
    {
        return view('meal-plans.create', ['recipes' => $this->availableRecipes($request)]);
    }

    public function store(MealPlanRequest $request): RedirectResponse
    {
        // Transaction: ถ้าขั้นใดพลาด ข้อมูลทั้งหมดจะถูกยกเลิก ไม่เหลือแผนที่ไม่สมบูรณ์
        $plan = DB::transaction(function () use ($request) {
            $plan = $request->user()->mealPlans()->create(
                $request->safe()->only(['name', 'plan_date', 'target_calories', 'notes'])
            );
            $this->syncItems($plan, $request->input('items', []));

            return $plan;
        });

        return redirect()->route('meal-plans.show', $plan)->with('status', 'สร้างแผนมื้ออาหารเรียบร้อยแล้ว');
    }

    public function show(MealPlan $mealPlan): View
    {
        Gate::authorize('view', $mealPlan);

        $mealPlan->load('recipes.category');

        return view('meal-plans.show', [
            'plan'    => $mealPlan,
            'totals'  => $mealPlan->nutritionTotals(),                 // โภชนาการรวมของแผน
            'byMeal'  => $mealPlan->recipes->groupBy('pivot.meal_type'), // จัดกลุ่มตามมื้อ
        ]);
    }

    public function edit(Request $request, MealPlan $mealPlan): View
    {
        Gate::authorize('update', $mealPlan);

        $mealPlan->load('recipes');

        return view('meal-plans.edit', [
            'plan'    => $mealPlan,
            'recipes' => $this->availableRecipes($request),
        ]);
    }

    public function update(MealPlanRequest $request, MealPlan $mealPlan): RedirectResponse
    {
        Gate::authorize('update', $mealPlan);

        DB::transaction(function () use ($request, $mealPlan) {
            $mealPlan->update($request->safe()->only(['name', 'plan_date', 'target_calories', 'notes']));
            $this->syncItems($mealPlan, $request->input('items', []));
        });

        return redirect()->route('meal-plans.show', $mealPlan)->with('status', 'แก้ไขแผนมื้ออาหารเรียบร้อยแล้ว');
    }

    public function destroy(MealPlan $mealPlan): RedirectResponse
    {
        Gate::authorize('delete', $mealPlan);

        $mealPlan->delete();   // แถวใน meal_plan_recipe ถูกลบตามอัตโนมัติ (cascade)

        return redirect()->route('meal-plans.index')->with('status', 'ลบแผนมื้ออาหารเรียบร้อยแล้ว');
    }

    // สูตรที่เลือกใส่แผนได้: ของตัวเอง + สูตรสาธารณะ
    private function availableRecipes(Request $request)
    {
        $userId = $request->user()->id;

        return Recipe::where(fn ($q) => $q->where('user_id', $userId)->orWhere('is_public', true))
            ->orderBy('title')
            ->get(['id', 'title', 'calories']);
    }

    // บันทึกรายการสูตรในแผนใหม่ทั้งหมด (ลบของเก่าแล้วเพิ่มใหม่)
    // ตัดรายการซ้ำ (สูตรเดียวกัน + มื้อเดียวกัน) เพราะ Primary Key ของตารางกลางไม่ยอมให้ซ้ำ
    private function syncItems(MealPlan $plan, array $items): void
    {
        $plan->recipes()->detach();

        collect($items)
            ->unique(fn ($item) => $item['recipe_id'] . '-' . $item['meal_type'])
            ->each(fn ($item) => $plan->recipes()->attach($item['recipe_id'], [
                'meal_type' => $item['meal_type'],
                'servings'  => $item['servings'],
            ]));
    }
}
