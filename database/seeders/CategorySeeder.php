<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [
            ['อาหารจานหลัก',   'main-dish', '🍛', 'อาหารจานเดียวและกับข้าว'],
            ['ซุปและแกง',      'soup-curry', '🍲', 'ซุป ต้ม แกง'],
            ['สลัด',            'salad', '🥗', 'ผักสดและอาหารสุขภาพ'],
            ['อาหารเช้า',      'breakfast', '🥣', 'เมนูมื้อเช้า'],
            ['เครื่องดื่ม',     'drinks', '🥤', 'สมูทตี้และเครื่องดื่ม'],
            ['ของว่าง',         'snacks', '🍪', 'ของทานเล่นและของหวาน'],
        ];

        foreach ($rows as [$name, $slug, $icon, $desc]) {
            // updateOrInsert: รันซ้ำได้โดยข้อมูลไม่ซ้ำ
            DB::table('categories')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'icon' => $icon, 'description' => $desc, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
