<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{



    public function staffs() {
        return $this->hasMany("App\Staff", "department_id");
    }
}
