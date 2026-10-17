<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CuisineSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [
            ['ไทย',       'thai',     'TH', 'อาหารไทยดั้งเดิมและประยุกต์'],
            ['ญี่ปุ่น',    'japanese', 'JP', 'อาหารญี่ปุ่น'],
            ['อิตาเลียน', 'italian',  'IT', 'พาสต้า พิซซ่า และอื่นๆ'],
            ['จีน',       'chinese',  'CN', 'อาหารจีน'],
            ['ตะวันตก',   'western',  'US', 'อาหารตะวันตกทั่วไป'],
        ];

        foreach ($rows as [$name, $slug, $code, $desc]) {
            DB::table('cuisines')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'country_code' => $code, 'description' => $desc, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
