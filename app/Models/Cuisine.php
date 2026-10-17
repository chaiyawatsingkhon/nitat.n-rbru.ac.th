<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuisine extends Model
{
    protected $fillable = ['name', 'slug', 'country_code', 'description'];

    // สไตล์อาหาร 1 อัน มีได้หลายสูตรอาหาร (One-to-Many)
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }
}
