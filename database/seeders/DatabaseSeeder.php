<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // เรียกตามลำดับ: ข้อมูลหลักก่อน แล้วค่อยสูตรอาหาร (เพราะสูตรอ้างอิง FK)
        $this->call([
            CategorySeeder::class,
            CuisineSeeder::class,
            TagSeeder::class,
            RecipeSeeder::class,
        ]);
    }
}
