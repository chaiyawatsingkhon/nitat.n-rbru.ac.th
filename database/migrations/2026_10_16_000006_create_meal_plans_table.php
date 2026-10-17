<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ตารางแผนมื้ออาหาร (1 แผน = 1 วัน)
        Schema::create('meal_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // เจ้าของแผน
            $table->string('name', 120);                                    // ชื่อแผน
            $table->date('plan_date');                                      // วันที่ของแผน
            $table->unsignedSmallInteger('target_calories')->nullable();    // เป้าหมายแคลอรี่ต่อวัน
            $table->text('notes')->nullable();                              // บันทึก
            $table->timestamps();

            $table->index(['user_id', 'plan_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
};
