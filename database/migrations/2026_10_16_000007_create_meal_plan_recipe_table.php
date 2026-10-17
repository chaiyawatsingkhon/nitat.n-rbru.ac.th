<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot table: แผนมื้ออาหาร <-> สูตรอาหาร พร้อมข้อมูลเพิ่มเติม (มื้อ, จำนวนเสิร์ฟ)
        Schema::create('meal_plan_recipe', function (Blueprint $table) {
            $table->foreignId('meal_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);   // มื้อ
            $table->decimal('servings', 4, 1)->default(1);   // จำนวนเสิร์ฟที่กินจริง (ใช้คูณโภชนาการ)

            // สูตรเดียวกันใส่ได้หลายมื้อ แต่ซ้ำในมื้อเดียวกันไม่ได้
            $table->primary(['meal_plan_id', 'recipe_id', 'meal_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plan_recipe');
    }
};
