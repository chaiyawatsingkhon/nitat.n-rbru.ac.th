<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // ตัดแถวที่ไม่ได้เลือกสูตรออกก่อนตรวจสอบ (ฟอร์มอาจมีแถวว่าง)
    protected function prepareForValidation(): void
    {
        $items = collect($this->input('items', []))
            ->filter(fn ($item) => !empty($item['recipe_id']))
            ->values()
            ->all();

        $this->merge(['items' => $items]);
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        // สูตรที่เลือกได้: ของตัวเอง หรือสูตรสาธารณะ และต้องไม่ถูกลบ
        $allowedRecipe = Rule::exists('recipes', 'id')->where(function ($q) use ($userId) {
            $q->whereNull('deleted_at')
              ->where(fn ($q) => $q->where('user_id', $userId)->orWhere('is_public', true));
        });

        return [
            'name'                => ['required', 'string', 'max:120'],
            'plan_date'           => ['required', 'date'],
            'target_calories'     => ['nullable', 'integer', 'min:0', 'max:10000'],
            'notes'               => ['nullable', 'string', 'max:2000'],
            'items'               => ['nullable', 'array', 'max:30'],
            'items.*.recipe_id'   => ['required', $allowedRecipe],
            'items.*.meal_type'   => ['required', 'in:breakfast,lunch,dinner,snack'],
            'items.*.servings'    => ['required', 'numeric', 'min:0.5', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'ชื่อแผน',
            'plan_date' => 'วันที่',
            'target_calories' => 'เป้าหมายแคลอรี่',
            'items.*.recipe_id' => 'สูตรอาหาร',
            'items.*.meal_type' => 'มื้อ',
            'items.*.servings' => 'จำนวนเสิร์ฟ',
        ];
    }
}
