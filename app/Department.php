<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
      'nama'
    ];

    public function serviceTypes() {
        return $this->hasMany('App\ServiceType', "department_id");
    }

    public function staffs() {
        return $this->hasMany("App\Staff", "department_id");
    }
}
