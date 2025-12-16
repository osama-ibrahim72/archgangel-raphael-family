<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;

class Professor extends User
{
    protected $fillable =[
        'name',
        'email',
        'password',
        'phone',
        'address',
        'dob',
        'gender',
        'collage',
        'level_id'
    ];
    protected $guard_name = 'web'; // default used by spatie


    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $studentRole = \Spatie\Permission\Models\Role::where('name', UserType::PROFESSOR)->first();

            if ($studentRole && !$model->hasRole($studentRole->name)) {
                $model->assignRole($studentRole);
            }

//            $model->assignRole(\Spatie\Permission\Models\Role::whereIn('name', [UserType::STUDENT])->first());
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('student', function (Builder $builder) {
            $builder->whereHas('roles', function (Builder $builder) {
                $builder->whereIn('name', [\App\Enums\UserType::PROFESSOR]);
            });
        });
    }
}
