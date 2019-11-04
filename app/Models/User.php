<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_name', 'phone', 'home_phone', 'address', 'status', 'deleted', 'date', 'type', 'city_id',
        'company_id', 'password','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public static function getAllManagers()
    {
        return User::where(['status' => 'MANAGER'])->get();
    }

    public function getFullName()
    {
        return $this->name. " ".$this->last_name;
    }
}