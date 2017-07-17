<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
      'nama',
      'biaya',
      'department_id'
    ];

    protected $hidden = [

    ];

    public function department() {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function services() {
        return $this->belongsToMany("App\Service", "service_service_type");
    }
}
