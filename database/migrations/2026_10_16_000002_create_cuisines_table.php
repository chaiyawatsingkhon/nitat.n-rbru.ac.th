<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ตารางสไตล์อาหาร เช่น ไทย ญี่ปุ่น อิตาเลียน
        Schema::create('cuisines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();          // ชื่อสไตล์อาหาร
            $table->string('slug', 120)->unique();          // ใช้ใน URL
            $table->char('country_code', 2)->nullable();    // รหัสประเทศ เช่น TH, JP
            $table->text('description')->nullable();        // คำอธิบาย
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuisines');
    }
};
