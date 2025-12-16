<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $fillable =[
        'name',
        'district',
        'phone',
        'email',
        'website',
        'address',
    ];

    public function fathers()
    {
        return $this->hasMany(Father::class);
    }
}
