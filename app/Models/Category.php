<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // ฟิลด์ที่อนุญาตให้บันทึกแบบ mass assignment (create / update)
    protected $fillable = ['name', 'slug', 'description', 'icon'];

    // หมวดหมู่ 1 อัน มีได้หลายสูตรอาหาร (One-to-Many)
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
}
