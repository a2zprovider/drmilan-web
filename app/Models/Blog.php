<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany('App\Models\BlogComment', 'blog_id', 'id');
    }
}
