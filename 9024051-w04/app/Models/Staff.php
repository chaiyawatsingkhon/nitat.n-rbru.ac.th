<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = ['title_id', 'first_name', 'last_name', 'position'];

    public function title()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }
}