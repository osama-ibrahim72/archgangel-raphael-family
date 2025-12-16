<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceUser extends Model
{
    protected $table = 'service_users';
    protected $fillable = [
        'service_id',
        'user_id',
        'assigned',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class , 'user_id' , 'id');
    }
}
