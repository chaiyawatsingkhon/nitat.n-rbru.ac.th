<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MealPlan extends Model
{
    protected $fillable = ['user_id', 'name', 'plan_date', 'target_calories', 'notes'];

    protected $casts = [
        'plan_date' => 'date', // กลายเป็นวัตถุ Carbon ใช้ ->format('d/m/Y') ได้
    ];

    // แผนนี้เป็นของผู้ใช้คนไหน (Many-to-One)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // แผนนี้มีสูตรอะไรบ้าง (Many-to-Many ผ่านตาราง meal_plan_recipe)
    // pivot มี meal_type (มื้อ) และ servings (จำนวนเสิร์ฟที่กินจริง)
    // เพิ่มสูตร: $plan->recipes()->attach($recipeId, ['meal_type' => 'lunch', 'servings' => 1.5]);
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'meal_plan_recipe')
            ->withPivot('meal_type', 'servings');
    }

    /**
     * คำนวณโภชนาการรวมของแผนนี้
     * สูตร: ผลรวมของ (ค่าโภชนาการต่อเสิร์ฟ x จำนวนเสิร์ฟที่กินจริงใน pivot)
     *
     * @return array{calories: float, protein: float, carbs: float, fat: float, fiber: float}
     */
    public function nutritionTotals(): array
    {
        $totals = ['calories' => 0.0, 'protein' => 0.0, 'carbs' => 0.0, 'fat' => 0.0, 'fiber' => 0.0];

        // ใช้ $this->recipes (ไม่ใส่วงเล็บ) เพื่อใช้ข้อมูลที่โหลดไว้แล้ว ลดจำนวน query
        foreach ($this->recipes as $recipe) {
            $servings = (float) $recipe->pivot->servings;

            $totals['calories'] += $recipe->calories * $servings;
            $totals['protein']  += $recipe->protein_g * $servings;
            $totals['carbs']    += $recipe->carbs_g * $servings;
            $totals['fat']      += $recipe->fat_g * $servings;
            $totals['fiber']    += $recipe->fiber_g * $servings;
        }

        return array_map(fn ($v) => round($v, 1), $totals);
    }

    // แคลอรี่รวม: ใช้เป็น $plan->total_calories
    public function getTotalCaloriesAttribute(): float
    {
        return $this->nutritionTotals()['calories'];
    }
}
