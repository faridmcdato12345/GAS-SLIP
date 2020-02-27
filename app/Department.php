<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];


    public function applicant(){
        return $this->hasMany(Applicant::class);
    }
    public function application(){
        return $this->hasMany(Application::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
}
