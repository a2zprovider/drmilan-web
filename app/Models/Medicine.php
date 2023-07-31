<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $guarded = [];
    protected $with = ['appointment'];

    public function appointment()
    {
        return $this->hasOne('App\Models\Appointment', 'id', 'appointment_id');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
