<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $table = 'activities';
    protected $fillable = ['activity_name', 'community_id', 'organization_id', 'activity_date'];

    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}