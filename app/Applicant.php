<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $guarded = [];

    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function application(){
        return $this->hasMany(Application::class);
    }
}
