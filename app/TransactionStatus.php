<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{

    protected $fillable = [
      'nama'
    ];


    public function services() {
        return $this->hasMany('App\Service', 'status_transaksi_id');
    }
}
