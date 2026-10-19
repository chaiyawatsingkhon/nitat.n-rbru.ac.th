<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('title')->insert([
            ['title_name' => 'นาย', 'created_at' => now(), 'updated_at' => now()],
            ['title_name' => 'นาง', 'created_at' => now(), 'updated_at' => now()],
            ['title_name' => 'นางสาว', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
