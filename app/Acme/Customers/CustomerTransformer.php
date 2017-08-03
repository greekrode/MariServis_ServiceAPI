<?php

namespace App\Acme\Customers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Manager;

use App\Extensions\Serializers\CustomSerializer;
use App\Customer;
use Auth;

class CustomerTransformer extends TransformerAbstract
{
    private $total;
    private $manager;

    public function __construct($total) {
        $this->total = $total;
        $this->manager = new Manager();
        $this->manager->setSerializer(new CustomSerializer());
    }

    public function transform(Customer $customer) {

        if($this->total == 1) {
            $cs = new CustomSerializer();
            $services = array();
            $new_service_formatted = array();
            $cars = array();
            $new_car_formatted = array();

            foreach ($customer->services as $service) {
                $resourceKey = "serviceRecord";
                // formatted
                $new_service_formatted['url'] = route('api.v1.services.show', ['id' => $service->id]);
                $new_service_formatted['date'] = (String) $service->created_at;
                $new_service_formatted['refNo'] = (String) $service->ref_no;

                if ($service->car) { // service has car?
                    $new_service_formatted['car'] = [
                        'url' => route('api.v1.cars.show', ['id' => $service->car->id]),
                        'name' => $service->car->nama,
                        'licensePlate' => $service->car->no_plat
                    ];
                }
                // $new_service_formatted['serviceTypes'] = $serviceTypes;
                // $new_service_formatted['paymentMethod'] = ucfirst($service->payment->metode_pembayaran);
                // $new_service_formatted['transactionStatus'] = ucfirst($service->transactionStatus->nama);
                // $new_service_formatted['serviceStatus'] = ucfirst($service->serviceStatus->nama);

                $services[] = $cs->item($resourceKey, $new_service_formatted);
            }

            foreach ($customer->cars as $car) {
                $resourceKey = "car";
                //formatted
                $new_car_formatted['url'] = route('api.v1.cars.show', ['id' => $car->id]);
                $new_car_formatted['name'] = $car->nama;
                $new_car_formatted['licensePlate'] = $car->no_plat;

                $cars[] = $cs->item($resourceKey, $new_car_formatted);
            }



            if (count($cars) > 0) {
                return [
                    'name' => ucfirst($customer->nama),
                    'address' => (String) $customer->alamat,
                    'phoneNumber' => (String) $customer->no_telp,
                    'serviceRecords' => $services,
                    'cars' => $cars,
                ];
            } else {
                return [
                    'name' => ucfirst($customer->nama),
                    'address' => (String) $customer->alamat,
                    'phoneNumber' => (String) $customer->no_telp,
                    'serviceRecords' => $services,
                ];
            }
        } else {
            return [
                'url' => (String) route('api.v1.customers.show', ['id' => $customer->id]),
                'name' => ucfirst($customer->nama),
                // 'address' => (String) $customer->alamat,
                // 'phoneNumber' => (Int) $customer->no_telp,
            ];
        }
    }
}



// $resources = [];
//
// foreach ($data as $resource) {
//     $resources[] = $this->item($resourceKey, $resource)['data'];
// }
//
// $resource = [
//     'data' => [
//         'type' => $resourceKey,
//         'id' => "$id",
//         'attributes' => $data,
//     ],
// ];
