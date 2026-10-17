<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes; // ลบแบบกู้คืนได้ (ใช้คอลัมน์ deleted_at)

    protected $fillable = [
        'user_id', 'category_id', 'cuisine_id',
        'title', 'slug', 'description', 'ingredients', 'instructions', 'image_path',
        'prep_minutes', 'cook_minutes', 'servings', 'difficulty',
        'calories', 'protein_g', 'carbs_g', 'fat_g', 'fiber_g',
        'is_public',
    ];

    // แปลงชนิดข้อมูลอัตโนมัติเมื่ออ่านค่าจากฐานข้อมูล
    protected $casts = [
        'is_public' => 'boolean',
        'protein_g' => 'float',
        'carbs_g'   => 'float',
        'fat_g'     => 'float',
        'fiber_g'   => 'float',
    ];

    // ---------- Relationships ----------

    // สูตรนี้เป็นของผู้ใช้คนไหน (Many-to-One)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // สูตรนี้อยู่หมวดหมู่ไหน (Many-to-One)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // สูตรนี้เป็นอาหารสไตล์ไหน (Many-to-One, อาจเป็น null)
    public function cuisine(): BelongsTo
    {
        return $this->belongsTo(Cuisine::class);
    }

    // สูตรนี้มีแท็กอะไรบ้าง (Many-to-Many ผ่านตาราง recipe_tag)
    // ใช้ $recipe->tags()->sync([1, 2, 3]) เพื่อบันทึกแท็ก
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // สูตรนี้อยู่ในแผนมื้ออาหารไหนบ้าง (Many-to-Many ผ่านตาราง meal_plan_recipe)
    // withPivot: ดึงคอลัมน์เพิ่มเติมในตารางกลางมาด้วย
    public function mealPlans(): BelongsToMany
    {
        return $this->belongsToMany(MealPlan::class, 'meal_plan_recipe')
            ->withPivot('meal_type', 'servings');
    }

    // ---------- Accessors (เรียกใช้เหมือนฟิลด์: $recipe->total_minutes) ----------

    // เวลาทำทั้งหมด = เวลาเตรียม + เวลาปรุง
    public function getTotalMinutesAttribute(): int
    {
        return $this->prep_minutes + $this->cook_minutes;
    }

    // URL ของรูปอาหาร (ต้องรัน php artisan storage:link ก่อน) ถ้าไม่มีรูปคืนค่า null
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    // ชื่อระดับความยากเป็นภาษาไทย
    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'easy' => 'ง่าย',
            'medium' => 'ปานกลาง',
            'hard' => 'ยาก',
            default => '-',
        };
    }

    // ---------- Query Scopes (ใช้ต่อท้ายเช่น Recipe::public()->search('ไก่')->get()) ----------

    // เฉพาะสูตรที่แชร์สาธารณะ
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    // ค้นหาจากชื่อสูตรหรือคำอธิบาย
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (!$keyword) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }
}
