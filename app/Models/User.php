<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ผู้ใช้ 1 คน มีได้หลายสูตรอาหาร (One-to-Many)
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    // ผู้ใช้ 1 คน มีได้หลายแผนมื้ออาหาร (One-to-Many)
    public function mealPlans(): HasMany
    {
        return $this->hasMany(MealPlan::class);
    }
}
