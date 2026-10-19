<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunitySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('community')->insert([
            ['community_name' => 'ชุมชนบ้านดอนแก้ว', 'community_location' => 'ต.ดอนแก้ว อ.เมือง', 'created_at' => now(), 'updated_at' => now()],
            ['community_name' => 'ชุมชนบ้านท่าศาลา', 'community_location' => 'ต.ท่าศาลา อ.เมือง', 'created_at' => now(), 'updated_at' => now()],
            ['community_name' => 'ชุมชนบ้านป่าแดด', 'community_location' => 'ต.ป่าแดด อ.เมือง', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
