<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activities')->insert([
            ['activity_name' => 'โครงการปลูกป่า', 'activity_date' => '2026-03-15', 'community_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['activity_name' => 'อบรมคอมพิวเตอร์', 'activity_date' => '2026-05-20', 'community_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['activity_name' => 'ค่ายอาสาพัฒนา', 'activity_date' => '2026-07-10', 'community_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
