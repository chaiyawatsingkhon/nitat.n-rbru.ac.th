<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [
            // [ชื่อ, slug, สี, ประเภท]
            ['โปรตีนสูง',   'high-protein', '#ef4444', 'nutrition'],
            ['คาร์บต่ำ',    'low-carb',     '#f59e0b', 'nutrition'],
            ['แคลอรี่ต่ำ',  'low-calorie',  '#10b981', 'nutrition'],
            ['มังสวิรัติ',  'vegetarian',   '#22c55e', 'dietary'],
            ['ไม่มีกลูเตน', 'gluten-free',  '#8b5cf6', 'dietary'],
            ['ทำง่าย',      'easy',         '#3b82f6', 'skill'],
            ['ทำเร็ว',      'quick',        '#06b6d4', 'skill'],
        ];

        foreach ($rows as [$name, $slug, $color, $type]) {
            DB::table('tags')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'color' => $color, 'type' => $type, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
