<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ตารางแท็ก (ใช้กับสูตรอาหารแบบ Many-to-Many)
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();                       // ชื่อแท็ก
            $table->string('slug', 80)->unique();                       // ใช้ใน URL
            $table->string('color', 7)->default('#6b7280');             // สีแท็ก (hex)
            // ประเภทแท็ก: อาหารเฉพาะกลุ่ม / โภชนาการ / ระดับทักษะ
            $table->enum('type', ['dietary', 'nutrition', 'skill'])->default('dietary');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
