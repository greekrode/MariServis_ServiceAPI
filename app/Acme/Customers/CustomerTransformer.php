<?php

namespace App\Acme\Customers;

use League\Fractal\TransformerAbstract;

use App\Customer;

class CustomerTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Customer $customer) {
        if($this->total == 1) {
            $services = $customer->services()->get([
                'id',
                'created_at',
                'total_biaya',
                'status_transaksi_id',
                'payment_id',
            ]);

            return [
                'name' => $customer->nama,
                'address' => (String) $customer->alamat,
                'phone_number' => (Int) $customer->no_telp,
                'service_records' => [
                    $services,
                ],
            ];
        } else {
            return [
                'url' => (String) route('api.v1.customers.show', ['id' => $customer->id]),
                'name' => $customer->nama,
                'address' => (String) $customer->alamat,
                'phone_number' => (Int) $customer->no_telp,
            ];
        }
    }
}
