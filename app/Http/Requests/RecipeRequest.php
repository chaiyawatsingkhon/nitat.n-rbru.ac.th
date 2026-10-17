<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    // การเช็กสิทธิ์ทำใน Controller ผ่าน Policy จึงอนุญาตตรงนี้
    public function authorize(): bool
    {
        return true;
    }

    // ถ้าผู้ใช้เว้นช่องตัวเลขว่างไว้ ให้ถือเป็น 0 (กันฐานข้อมูล error)
    protected function prepareForValidation(): void
    {
        $defaults = [];
        foreach (['prep_minutes', 'cook_minutes', 'calories', 'protein_g', 'carbs_g', 'fat_g', 'fiber_g'] as $field) {
            if ($this->input($field) === null || $this->input($field) === '') {
                $defaults[$field] = 0;
            }
        }
        $this->merge($defaults);
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:150'],
            'category_id'  => ['required', 'exists:categories,id'],
            'cuisine_id'   => ['nullable', 'exists:cuisines,id'],
            'description'  => ['nullable', 'string', 'max:500'],
            'ingredients'  => ['required', 'string'],
            'instructions' => ['required', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // ไม่เกิน 2 MB
            'remove_image' => ['nullable', 'boolean'],
            'prep_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'cook_minutes' => ['required', 'integer', 'min:0', 'max:1440'],
            'servings'     => ['required', 'integer', 'min:1', 'max:50'],
            'difficulty'   => ['required', 'in:easy,medium,hard'],
            'calories'     => ['required', 'integer', 'min:0', 'max:5000'],
            'protein_g'    => ['required', 'numeric', 'min:0', 'max:999'],
            'carbs_g'      => ['required', 'numeric', 'min:0', 'max:999'],
            'fat_g'        => ['required', 'numeric', 'min:0', 'max:999'],
            'fiber_g'      => ['required', 'numeric', 'min:0', 'max:999'],
            'is_public'    => ['nullable', 'boolean'],
            'tags'         => ['nullable', 'array'],
            'tags.*'       => ['integer', 'exists:tags,id'],
        ];
    }

    // ชื่อฟิลด์ภาษาไทยที่แสดงในข้อความ error
    public function attributes(): array
    {
        return [
            'title' => 'ชื่อสูตร',
            'category_id' => 'หมวดหมู่',
            'ingredients' => 'วัตถุดิบ',
            'instructions' => 'วิธีทำ',
            'image' => 'รูปภาพ',
            'prep_minutes' => 'เวลาเตรียม',
            'cook_minutes' => 'เวลาปรุง',
            'servings' => 'จำนวนเสิร์ฟ',
            'difficulty' => 'ระดับความยาก',
            'calories' => 'แคลอรี่',
            'protein_g' => 'โปรตีน',
            'carbs_g' => 'คาร์โบไฮเดรต',
            'fat_g' => 'ไขมัน',
            'fiber_g' => 'ใยอาหาร',
        ];
    }
}
