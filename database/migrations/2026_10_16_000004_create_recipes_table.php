<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ตารางสูตรอาหารหลัก
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();

            // --- Foreign Keys ---
            // ลบผู้ใช้ -> ลบสูตรของผู้ใช้นั้นด้วย
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // มีสูตรอยู่ในหมวดหมู่ -> ห้ามลบหมวดหมู่
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            // ลบสไตล์อาหาร -> cuisine_id ของสูตรเป็น null
            $table->foreignId('cuisine_id')->nullable()->constrained()->nullOnDelete();

            // --- ข้อมูลทั่วไป ---
            $table->string('title', 150);                   // ชื่อสูตร
            $table->string('slug', 170)->unique();          // ใช้ใน URL
            $table->text('description')->nullable();        // คำอธิบายสั้น
            $table->text('ingredients');                    // วัตถุดิบ (1 บรรทัด = 1 รายการ)
            $table->longText('instructions');               // วิธีทำ
            $table->string('image_path')->nullable();       // path รูปอาหาร

            // --- เวลาและความยาก ---
            $table->unsignedSmallInteger('prep_minutes')->default(0);   // เวลาเตรียม (นาที)
            $table->unsignedSmallInteger('cook_minutes')->default(0);   // เวลาปรุง (นาที)
            $table->unsignedTinyInteger('servings')->default(1);        // จำนวนเสิร์ฟของสูตร
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');

            // --- โภชนาการ (ต่อ 1 เสิร์ฟ) ---
            $table->unsignedSmallInteger('calories')->default(0);       // kcal
            $table->decimal('protein_g', 6, 1)->default(0);             // โปรตีน
            $table->decimal('carbs_g', 6, 1)->default(0);               // คาร์โบไฮเดรต
            $table->decimal('fat_g', 6, 1)->default(0);                 // ไขมัน
            $table->decimal('fiber_g', 6, 1)->default(0);               // ใยอาหาร

            $table->boolean('is_public')->default(false);   // แชร์ให้คนอื่นเห็นหรือไม่
            $table->softDeletes();                          // deleted_at (ลบแบบกู้คืนได้)
            $table->timestamps();

            // index ช่วยให้ค้นหา/กรองเร็วขึ้น
            $table->index(['user_id', 'category_id']);
            $table->index('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
