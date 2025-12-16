<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable =[
        'title',
        'notes',
        'teacher_id',
        'date',
        'time',
        'inside'
    ];


    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class);
    }

    public function sections()
    {
        return $this->hasMany(\App\Models\Section::class);
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class);
    }

}
