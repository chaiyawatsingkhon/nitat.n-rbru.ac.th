<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    // ดูสูตรได้ถ้าเป็นเจ้าของ หรือสูตรนั้นเปิดสาธารณะ
    public function view(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id || $recipe->is_public;
    }

    // แก้ไข/ลบได้เฉพาะเจ้าของ
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }

    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }
}
