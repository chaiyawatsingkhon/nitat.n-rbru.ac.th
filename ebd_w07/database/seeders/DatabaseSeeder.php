<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Title;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add sample Titles (Thai)
        Title::create(['tit_name' => 'นาย']);
        Title::create(['tit_name' => 'นาง']);
        Title::create(['tit_name' => 'นางสาว']);
        Title::create(['tit_name' => 'ดร.']);
        Title::create(['tit_name' => 'ผศ.']);
        Title::create(['tit_name' => 'รศ.']);
        Title::create(['tit_name' => 'ศ.']);

        // Add sample Organizations (Thai)
        Organization::create(['org_name' => 'คณะวิทยาศาสตร์']);
        Organization::create(['org_name' => 'คณะวิศวกรรมศาสตร์']);
        Organization::create(['org_name' => 'คณะบริหารธุรกิจ']);
    }
}
