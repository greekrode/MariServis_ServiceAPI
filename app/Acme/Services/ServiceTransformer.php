<?php

namespace App\Acme\Services;

use League\Fractal\TransformerAbstract;

use App\Service;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Extensions\Serializers\CustomSerializer;

class ServiceTransformer extends TransformerAbstract
{
    private $total;
    private $manager;

    public function __construct($total) {
        $this->total = $total;
        $this->manager = new Manager();
        $this->manager->setSerializer(new CustomSerializer());
    }

    public function transform(Service $service) {

        if ($this->total == 1) {
            $inventory_name = array();
            $inventory_price = array();
            $inventory_qty = array();
            $qty_multiply_price = array();

            $service_types_name = array();
            $service_types_price = array();

            $service_staffs = array();

            foreach ($service->inventories as $inventory) {
                array_push($inventory_name, $inventory->nama);
                array_push($inventory_qty, $inventory->qty);
                array_push($inventory_price, $inventory->harga);

                array_push($qty_multiply_price, ((Double)$inventory->qty * (Double)$inventory->harga));
            }

            foreach ($service->serviceTypes as $serviceType) {
                array_push($service_types_name, $serviceType->nama);
                array_push($service_types_price, (Double)$serviceType->biaya);
            }

            foreach ($service->staffs as $staff) {
                array_push($service_staffs, $staff->nama);
            }

            if (count($inventory_name) == 0) {
                return [
                    'id' => $service->id,
                    'customer' => $service->customer_id,
                    'service_types' => $service_types_name,
                    'payment_method' => $service->payment->metode_pembayaran,
                    'transaction_status' => $service->transactionStatus->nama,
                    'service_status' => $service->serviceStatus->nama,
                    'total_biaya' => ($qty_multiply_price + $service_types_price),
                    'staffs' => $service_staffs,
                ];
            } else {
                // $cs = new CustomSerializer();
                // $inventories =$cs->collection("inventory", $inventory_name);

                return [
                    'id' => $service->id,
                    'customer' => $service->customer_id,
                    'inventories' => $inventory_name,
                    'qty' => $inventory_qty,
                    // 'service_types' => $service->service_types_id,
                    'service_types' => $service_types_name,
                    'payment_method' => $service->payment->metode_pembayaran,
                    'transaction_status' => $service->transactionStatus->nama,
                    'service_status' => $service->serviceStatus->nama,
                    'total_biaya' => ($qty_multiply_price + $service_types_price),
                    'staffs' => $service_staffs,
                ];
            }

        } else {


            return [
                'url' => (String) route('api.v1.services.show', ['id' => $service->id]),
                'id' => $service->id,
                'customer' => $service->customer_id,
            ];
        }
    }
}
