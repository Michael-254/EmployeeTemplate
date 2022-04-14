<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'site',
        'department',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Employees(){
        return $this->hasOne(EmployeeTemplate::class)->withDefault();
    }

    public function jobInfos(){
        return $this->hasOne(JobInfo::class)->withDefault();
    }

    public function emergency(){
        return $this->hasOne(EmergencyC::class)->withDefault();
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function Assets(){
        return $this->hasMany(CompanyAsset::class);
    }

    public function trainings(){
        return $this->hasMany(Training::class);
    }
}
