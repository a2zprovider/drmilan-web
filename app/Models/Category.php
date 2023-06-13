<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    protected $counts = ['doctors'];

    public function doctors()
    {
        return $this->hasMany('App\Models\Doctor', 'category_id', 'id');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
