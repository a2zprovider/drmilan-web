<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['avg_rating', 'image_url'];
    protected $with = ['category'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('images/doctor/' . $this->image);
        } else {
            return null;
        }
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id')->select(['id', 'title']);
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'doctor_id', 'id');
    }

    public function getAvgRatingAttribute()
    {
        return number_format((float)round($this->reviews->average('rating'), 2), 1, '.', '');
    }
}
