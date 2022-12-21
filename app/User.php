<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getusers()
    {
        return $this->belongsTo('App\User','team_member', 'id');
    }
    public function getdepartment()
    {
        return $this->belongsTo('App\Designation','department', 'id');
    }
    public function getskill()
    {
        return $this->belongsTo('App\Skill','skill', 'id');
    }
    public function getTasks(){
        return $this->hasMany('App\Task','user_id','id')->where('approved', 0);
    }
    public function getTasksCeo(){
        return $this->hasMany('App\Task','user_id','id')->where('approved', 0);
    }
}

