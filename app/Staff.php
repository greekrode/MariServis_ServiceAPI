<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{


    public function department() {
        return $this->belongsTo("App\Department", "department_id");
    }

    public function services() {
        return $this->belongsToMany("App\Service", "service_staff");
    }
}
