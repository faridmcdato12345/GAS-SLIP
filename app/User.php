<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','password','role_id','is_active','department_id','username','signature_id'
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

    public function Role(){
        return $this->belongsTo('App\Role');
    }
    public function Department(){
        return $this->belongsTo('App\Department');
    }
    public function DepartmentPosition(){
        return $this->belongsTo('App\DepartmentPosition');
    }
    public function isAdmin(){
        if($this->role_id == '2' && $this->is_active == '1'){
            return true;
        }
        return false;
    }
    public function superAdmin(){
        if($this->role_id == '1' && $this->is_active == '1' ){
            return true;
        }
        return false;
    }
    public function otherUser(){
        if($this->role_id >= '3' && $this->is_active == '1'){
            return true;
        }
        return false;
    }
    public function signature(){
        return $this->belongsTo(Signature::class);
    }
}
