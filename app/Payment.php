<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{// payment method here

    protected $fillable = [
      'nama'
    ];


    public function services() {
        return $this->hasMany("App\Service", "payment_id");
    }
}
