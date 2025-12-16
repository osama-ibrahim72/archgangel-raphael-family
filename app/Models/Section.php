<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable =[
        'title',
        'notes',
        'teacher_id',
        'father_id',
        'sort',
        'meeting_id',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class );
    }

    public function father()
    {
        return $this->belongsTo(\App\Models\Father::class);
    }
}
