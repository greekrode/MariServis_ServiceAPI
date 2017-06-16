<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{



    public function services() {
        return $this->belongsToMany("App\Service", "service_service_type");
    }
}
