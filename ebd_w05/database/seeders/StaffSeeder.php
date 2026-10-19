<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('staff')->insert([
            ['first_name' => 'สมชาย', 'last_name' => 'ใจดี', 'title_id' => 1, 'organization_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'สมหญิง', 'last_name' => 'รักเรียน', 'title_id' => 3, 'organization_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'วิภา', 'last_name' => 'สุขสันต์', 'title_id' => 2, 'organization_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
