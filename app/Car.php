<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    public function customer() {
        return $this->belongsTo("App\Customer", "customer_id");
    }
}
