<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $hidden = [

    ];



    public function inventories() {
        return $this->belongsToMany("App\Inventory", "inventory_service");
    }

    public function customer() {
        return $this->belongsTo("App\Customer", "customer_id");
    }

    public function payment() {
        return $this->belongsTo("App\Payment", "payment_id");
    }

    public function staffs() {
        return $this->belongsToMany("App\Staff", "service_staff");
    }

    public function serviceTypes() {
        return $this->belongsToMany("App\ServiceType", "service_service_type");
    }

    public function transactionStatus() {
        return $this->belongsTo("App\TransactionStatus", "status_transaksi_id");
    }

    public function serviceStatus() {
        return $this->belongsTo("App\serviceStatus", "status_service_id");
    }
}
