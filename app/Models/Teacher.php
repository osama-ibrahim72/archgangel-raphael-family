<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Teacher extends User
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
        'level_id',
        'job'
    ];
    protected $guard_name = 'web'; // default used by spatie


    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $studentRole = \Spatie\Permission\Models\Role::where('name', UserType::TEACHER)->first();

            if ($studentRole && !$model->hasRole($studentRole->name)) {
                $model->assignRole($studentRole);
            }

//            $model->assignRole(\Spatie\Permission\Models\Role::whereIn('name', [UserType::STUDENT])->first());
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('teacher', function (Builder $builder) {
            $builder->whereHas('roles', function (Builder $builder) {
                $builder->whereIn('name', [\App\Enums\UserType::TEACHER]);
            });
        });
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function father()
    {
        return $this->belongsTo(Father::class);
    }
}
