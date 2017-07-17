<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'ref_no',
        'customer_id',
        'car_id',
        'payment_id',
        'status_transaksi_id',
        'status_service_id',
    ];


    protected $hidden = [
      "updated_at",
      // "total_biaya",
      // "pivot",
      // "status_transaksi_id",
      // "status_service_id",
      // "payment_id",
      // "customer_id",
    ];



    public function inventories() { // REMEMBER: withPivot('...') , to get third party / pivot table column.
        return $this->belongsToMany("App\Inventory", "inventory_service")->withPivot('qty', 'total_harga');
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

    public function car() {
        return $this->belongsTo("App\Car", "car_id");
    }
}
