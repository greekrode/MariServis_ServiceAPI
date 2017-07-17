<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'no_telp',
    ];

    protected $hidden = [
      'created_at',
      'updated_at',
    ];

    public function cars() {
        return $this->hasMany("App\Car", "customer_id");
    }

    public  function services() {
        return $this->hasMany("App\Service", "customer_id");
    }

    public function user() {
        return $this->belongsTo("App\User", "user_id");
    }
}
