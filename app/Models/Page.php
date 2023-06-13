<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
