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
            $cs = new CustomSerializer();
            $inventories = [];
            $serviceTypes = [];

            foreach ($service->inventories as $inventory) {
                $resourceKey = "inventory";

                // formatted
                $new_inventory_formatted = array();
                $new_inventory_formatted['url'] = route('api.v1.inventories.show', ['id' => $inventory->id]);
                $new_inventory_formatted['name'] = ucfirst($inventory['nama']);
                $new_inventory_formatted['price'] = '$' . (Double) $inventory['harga'];
                $new_inventory_formatted['quantity'] = (Int) $inventory->pivot->qty;

                $inventories[] = $cs->item($resourceKey, $new_inventory_formatted);
            }

            foreach ($service->serviceTypes as $serviceType) {
                $resourceKey = "serviceType";
                $serviceType_id = (Int) $serviceType->id;

                // formatted
                $new_serviceType_formatted = array();
                $new_serviceType_formatted['url'] = route('api.v1.service_types.show', ['id' => $serviceType->id]);
                $new_serviceType_formatted['name'] = ucfirst($serviceType['nama']);
                $new_serviceType_formatted['charge'] = '$' . (Double) $serviceType['biaya'];
                // $new_serviceType_formatted['department'] = array();
                // $new_serviceType_formatted['department']['url'] = route('api.v1.departments.show', ['id' => $serviceType['department_id']]);
                // $new_serviceType_formatted['department']['name'] = $serviceType->department->nama;

                // $serviceTypes[] = $cs->item($resourceKey, $serviceType->whereId($serviceType_id)
                //                                                       ->get(['nama', 'biaya'])
                //                                                       ->toArray());
                $serviceTypes[] = $cs->item($resourceKey, $new_serviceType_formatted);
            }

            $staffs = [];
            foreach ($service->staffs as $staff) {
                $resourceKey = "staff";
                $staff_id = (Int) $staff->id;

                // formatted
                $new_staff_formatted = array();
                $new_staff_formatted['name'] = ucfirst($staff->nama);

                $staffs[] = $cs->item($resourceKey, $new_staff_formatted);
            }



            $inventory_name = array();
            // $inventory_price = array();
            // $inventory_qty = array();
            $qty_multiply_price = array();

            // $service_types_name = array();
            $service_types_price = array();

            // $service_staffs = array();

            foreach ($service->inventories as $inventory) {
                array_push($inventory_name, $inventory->nama);
                // array_push($inventory_qty, $inventory->qty);
                // array_push($inventory_price, $inventory->harga);

                array_push($qty_multiply_price, ((Double)$inventory->pivot->total_harga));
            }

            foreach ($service->serviceTypes as $serviceType) {
                // array_push($service_types_name, $serviceType->nama);
                array_push($service_types_price, (Double)$serviceType->biaya);
            }

            // foreach ($service->staffs as $staff) {
            //     array_push($service_staffs, $staff->nama);
            // }

            $customer = [
                'url' => (string) route('api.v1.customers.show', ['id' => $service['customer_id']]),
                // 'id' => (Int) $service->customer_id,
                'name' => ucfirst($service->customer->nama)
            ];

            if ($service->car) {
                $car = [
                    'url' => (string) route('api.v1.cars.show', ['id' => $service->car->id]),
                    'name' => $service->car->nama,
                    'licensePlate' => $service->car->no_plat
                ];
            } else {
                $car = [];
            }

            $total_biaya = (Double) array_sum($qty_multiply_price) + (Double) array_sum($service_types_price);

            if (count($inventory_name) == 0) {

                return [
                    'date' => (String) $service->created_at,
                    'refNo' => (String) $service->ref_no,
                    'customer' => $customer,
                    'serviceTypes' => $serviceTypes,
                    'paymentMethod' => ucfirst($service->payment->metode_pembayaran),
                    'transactionStatus' => ucfirst($service->transactionStatus->nama),
                    'serviceStatus' => ucfirst($service->serviceStatus->nama),
                    'totalCost' => '$' . $total_biaya,
                    'car' => $car,
                    // 'staffs' => $service_staffs,
                    // 'staffs' => $staffs, // NO NEED STAFF CAUSE WE KNOW THE DEPATMENT
                ];
            } else if (count($serviceTypes) == 0) {
                return [
                    'date' => (String) $service->created_at,
                    'refNo' => (String) $service->ref_no,
                    'customer' => $customer,
                    'inventories' => $inventories,
                    'paymentMethod' => ucfirst($service->payment->metode_pembayaran),
                    'transactionStatus' => ucfirst($service->transactionStatus->nama),
                    'serviceStatus' => ucfirst($service->serviceStatus->nama),
                    'totalCost' => '$' . $total_biaya,
                    'car' => $car,
                    // 'staffs' => $staffs, // NO NEED STAFF CAUSE WE KNOW THE DEPATMENT
                ];
            }else {
                // $cs = new CustomSerializer();
                // $inventories =$cs->collection("inventory", $inventory_name);

                return [
                    'date' => (String) $service->created_at,
                    'refNo' => (String) $service->ref_no,
                    'customer' => $customer,
                    // 'inventories' => $inventory_name, // ***THE FIRST ONE***
                    'inventories' => $inventories,
                    // 'service_types' => $service->service_types_id,
                    // 'service_types' => $service_types_name, // ***THE FIRST ONE***
                    'serviceTypes' => $serviceTypes,
                    'paymentMethod' => ucfirst($service->payment->metode_pembayaran),
                    'transactionStatus' => ucfirst($service->transactionStatus->nama),
                    'serviceStatus' => ucfirst($service->serviceStatus->nama),
                    'totalCost' => '$' . $total_biaya,
                    'car' => $car,
                    // 'staffs' => $service_staffs,
                    // 'staffs' => $staffs, // NO NEED STAFF CAUSE WE KNOW THE DEPATMENT
                ];
            }

        } else {

            return [
                'url' => (String) route('api.v1.services.show', ['id' => $service->id]),
                'date' => (String) $service->created_at,
                'refNo' => (String) $service->ref_no,
                // 'customerId' => (Int) $service->customer_id,
                // 'customerName' => $service->customer->nama,
            ];
        }
    }
}
