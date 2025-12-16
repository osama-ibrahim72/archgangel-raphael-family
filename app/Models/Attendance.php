<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'meeting_id',
        'date',
        'time',
        'notes',
        'attend'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }


}
