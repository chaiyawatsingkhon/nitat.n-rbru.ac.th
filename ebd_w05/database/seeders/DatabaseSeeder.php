<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            TitleSeeder::class,
            OrganizationSeeder::class,
            CommunitySeeder::class,
            StaffSeeder::class,
            ActivitySeeder::class,
        ]);

        \Illuminate\Support\Facades\DB::table('tags')->insert([
            ['tag_name' => 'ด่วนที่สุด', 'created_at' => now(), 'updated_at' => now()],
            ['tag_name' => 'ลับ', 'created_at' => now(), 'updated_at' => now()],
            ['tag_name' => 'ประชาสัมพันธ์', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
