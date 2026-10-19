<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organization')->insert([
            ['org_name' => 'คณะวิทยาศาสตร์', 'org_address' => 'อาคาร 1', 'created_at' => now(), 'updated_at' => now()],
            ['org_name' => 'คณะวิศวกรรมศาสตร์', 'org_address' => 'อาคาร 2', 'created_at' => now(), 'updated_at' => now()],
            ['org_name' => 'คณะมนุษยศาสตร์', 'org_address' => 'อาคาร 3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
