<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot table: สูตรอาหาร <-> แท็ก (Many-to-Many)
        // ชื่อตารางต้องเรียงตามตัวอักษร (recipe, tag) เพื่อให้ Eloquent เดาชื่อได้เอง
        Schema::create('recipe_tag', function (Blueprint $table) {
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['recipe_id', 'tag_id']);       // กันติดแท็กซ้ำ
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_tag');
    }
};
