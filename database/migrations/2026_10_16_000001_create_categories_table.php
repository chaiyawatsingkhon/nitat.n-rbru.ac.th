<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ตารางหมวดหมู่อาหาร เช่น อาหารจานหลัก, สลัด, ของหวาน
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();          // ชื่อหมวดหมู่
            $table->string('slug', 120)->unique();          // ใช้ใน URL
            $table->text('description')->nullable();        // คำอธิบาย
            $table->string('icon', 10)->nullable();         // อีโมจิ/ไอคอน
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
