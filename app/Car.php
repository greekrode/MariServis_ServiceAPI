<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'nama',
        'jenis',
        'no_plat',
        'model',
    ];

    public function customer() {
        return $this->belongsTo("App\Customer", "customer_id");
    }

    public function services() {
        return $this->hasMany("App\Service", "car_id");
    }
}
