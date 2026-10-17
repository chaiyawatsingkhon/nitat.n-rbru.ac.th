<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // สูตรตัวอย่างต้องมีเจ้าของ: ใช้ผู้ใช้คนแรกในระบบ ถ้ายังไม่มีให้สร้างบัญชีทดลอง
        $userId = DB::table('users')->orderBy('id')->value('id');
        if (!$userId) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'ผู้ใช้ทดลอง',
                'email' => 'demo@example.com',
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // แปลง slug -> id เพื่อใช้อ้างอิง
        $cat = DB::table('categories')->pluck('id', 'slug');
        $cui = DB::table('cuisines')->pluck('id', 'slug');
        $tag = DB::table('tags')->pluck('id', 'slug');

        // [slug, title, category, cuisine, difficulty, prep, cook, servings, kcal, P, C, F, fiber, tags, description, ingredients, instructions]
        $recipes = [
            ['pad-kra-pao-chicken', 'ผัดกะเพราไก่ไข่ดาว', 'main-dish', 'thai', 'easy', 10, 8, 1, 520, 32, 48, 20, 3,
                ['high-protein', 'easy', 'quick'],
                'เมนูยอดฮิต รสจัดจ้าน ทำเร็ว',
                "อกไก่สับ 150 กรัม\nใบกะเพรา 1 กำมือ\nพริก 5 เม็ด\nกระเทียม 4 กลีบ\nซอสหอยนางรม 1 ช้อนโต๊ะ\nข้าวสวย 1 จาน\nไข่ไก่ 1 ฟอง",
                "1. โขลกพริกกับกระเทียมให้หยาบ\n2. ผัดพริกกระเทียมกับน้ำมันจนหอม\n3. ใส่ไก่ ผัดจนสุก ปรุงรส\n4. ใส่ใบกะเพรา ผัดพอสลด\n5. ทอดไข่ดาว เสิร์ฟพร้อมข้าว"],

            ['tom-yum-goong', 'ต้มยำกุ้งน้ำใส', 'soup-curry', 'thai', 'medium', 15, 15, 2, 180, 18, 10, 7, 2,
                ['low-calorie', 'gluten-free'],
                'ต้มยำน้ำใสรสเปรี้ยวเผ็ด แคลอรี่ต่ำ',
                "กุ้งสด 200 กรัม\nข่า ตะไคร้ ใบมะกรูด\nเห็ดฟาง 100 กรัม\nน้ำมะนาว 2 ช้อนโต๊ะ\nพริกขี้หนู 5 เม็ด",
                "1. ต้มน้ำใส่ข่า ตะไคร้ ใบมะกรูด\n2. ใส่เห็ดและกุ้ง ต้มจนสุก\n3. ปรุงรสด้วยน้ำปลา พริก\n4. ปิดไฟ ใส่น้ำมะนาว"],

            ['chicken-breast-salad', 'สลัดอกไก่ย่าง', 'salad', 'western', 'easy', 15, 10, 1, 320, 35, 12, 14, 5,
                ['high-protein', 'low-carb', 'low-calorie', 'easy'],
                'สลัดโปรตีนสูง เหมาะกับคนคุมน้ำหนัก',
                "อกไก่ 150 กรัม\nผักสลัดรวม 1 ถ้วย\nมะเขือเทศเชอร์รี่ 5 ลูก\nแตงกวา 1/2 ลูก\nน้ำสลัดน้ำมันมะกอก 1 ช้อนโต๊ะ",
                "1. ย่างอกไก่ให้สุก หั่นชิ้น\n2. จัดผักใส่ชาม\n3. วางไก่ด้านบน\n4. ราดน้ำสลัด"],

            ['banana-oatmeal', 'ข้าวโอ๊ตกล้วยหอม', 'breakfast', 'western', 'easy', 5, 5, 1, 280, 9, 48, 6, 6,
                ['vegetarian', 'low-calorie', 'easy', 'quick'],
                'มื้อเช้าอิ่มนาน ทำใน 10 นาที',
                "ข้าวโอ๊ต 1/2 ถ้วย\nนมสด 1 ถ้วย\nกล้วยหอม 1 ลูก\nน้ำผึ้ง 1 ช้อนชา",
                "1. ต้มข้าวโอ๊ตกับนมจนข้น\n2. หั่นกล้วยวางด้านบน\n3. ราดน้ำผึ้ง"],

            ['lemon-grilled-salmon', 'แซลมอนย่างมะนาว', 'main-dish', 'western', 'medium', 10, 15, 1, 410, 36, 4, 28, 1,
                ['high-protein', 'low-carb', 'gluten-free'],
                'ไขมันดี โอเมก้า 3 สูง',
                "เนื้อแซลมอน 1 ชิ้น (150 กรัม)\nมะนาว 1 ลูก\nเกลือ พริกไทย\nน้ำมันมะกอก 1 ช้อนชา",
                "1. หมักแซลมอนกับเกลือ พริกไทย\n2. ย่างหรือทอดด้วยไฟกลาง ด้านละ 4-5 นาที\n3. บีบมะนาวก่อนเสิร์ฟ"],

            ['chicken-teriyaki-don', 'ข้าวหน้าไก่เทอริยากิ', 'main-dish', 'japanese', 'easy', 10, 12, 1, 560, 30, 70, 16, 2,
                ['easy'],
                'ข้าวหน้าไก่ซอสหวานเค็มสไตล์ญี่ปุ่น',
                "สะโพกไก่ไม่มีหนัง 150 กรัม\nซอสเทอริยากิ 2 ช้อนโต๊ะ\nข้าวญี่ปุ่น 1 ถ้วย\nต้นหอมซอย",
                "1. ทอดไก่จนเหลือง\n2. ใส่ซอสเทอริยากิ เคี่ยวจนข้น\n3. หั่นไก่วางบนข้าว โรยต้นหอม"],

            ['spaghetti-carbonara', 'สปาเกตตีคาร์โบนาร่า', 'main-dish', 'italian', 'medium', 10, 15, 2, 640, 24, 70, 28, 3,
                [],
                'พาสต้าครีมมี่แบบอิตาเลียน',
                "สปาเกตตี 200 กรัม\nเบคอน 80 กรัม\nไข่แดง 2 ฟอง\nชีสพาร์เมซาน 40 กรัม\nพริกไทยดำ",
                "1. ต้มเส้นตามเวลาบนซอง\n2. ทอดเบคอนจนกรอบ\n3. ผสมไข่แดงกับชีส\n4. คลุกเส้นกับเบคอนนอกไฟ แล้วใส่ซอสไข่"],

            ['mixed-fruit-smoothie', 'สมูทตี้ผลไม้รวม', 'drinks', 'western', 'easy', 5, 0, 1, 150, 3, 33, 1, 4,
                ['vegetarian', 'low-calorie', 'gluten-free', 'easy', 'quick'],
                'เครื่องดื่มสดชื่น ใยอาหารสูง',
                "สตรอว์เบอร์รี่ 1/2 ถ้วย\nกล้วย 1/2 ลูก\nมะม่วง 1/2 ถ้วย\nโยเกิร์ตธรรมชาติ 1/2 ถ้วย\nน้ำแข็ง",
                "1. ใส่ทุกอย่างลงเครื่องปั่น\n2. ปั่นจนเนียน\n3. เทใส่แก้วเสิร์ฟ"],
        ];

        foreach ($recipes as $r) {
            [$slug, $title, $c, $u, $diff, $prep, $cook, $serv, $kcal, $p, $carb, $f, $fiber, $tags, $desc, $ing, $ins] = $r;

            // ข้ามถ้ามีสูตรนี้อยู่แล้ว (รัน seed ซ้ำได้)
            if (DB::table('recipes')->where('slug', $slug)->exists()) {
                continue;
            }

            $recipeId = DB::table('recipes')->insertGetId([
                'user_id' => $userId,
                'category_id' => $cat[$c],
                'cuisine_id' => $cui[$u],
                'title' => $title,
                'slug' => $slug,
                'description' => $desc,
                'ingredients' => $ing,
                'instructions' => $ins,
                'prep_minutes' => $prep,
                'cook_minutes' => $cook,
                'servings' => $serv,
                'difficulty' => $diff,
                'calories' => $kcal,
                'protein_g' => $p,
                'carbs_g' => $carb,
                'fat_g' => $f,
                'fiber_g' => $fiber,
                'is_public' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // ผูกแท็ก (ใส่ลง pivot table recipe_tag)
            foreach ($tags as $t) {
                DB::table('recipe_tag')->insert(['recipe_id' => $recipeId, 'tag_id' => $tag[$t]]);
            }
        }
    }
}
