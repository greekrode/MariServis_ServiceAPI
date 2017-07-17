<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceStatus extends Model
{

    protected $fillable = [
      'nama'
    ];

    public function services() {
        return $this->hasMany('App\Service', 'status_service_id');
    }
}
