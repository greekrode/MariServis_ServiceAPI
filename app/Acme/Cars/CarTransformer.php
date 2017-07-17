<?php

namespace App\Acme\Cars;

use League\Fractal\TransformerAbstract;

use App\Car;
use App\Extensions\Serializers\CustomSerializer;

class CarTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Car $car) {
        $customer = [
            'url' => (String) route('api.v1.customers.show', ['id' => $car->customer_id]),
            'name' => ucfirst($car->customer->nama),
        ];

        if($this->total == 1) {
            $cs = new CustomSerializer();
            $service_records = array();
            $new_service_record_formatted = array();

            foreach ($car->services as $service) {
                $resourceKey = "serviceRecord";
                // formatted
                $new_service_record_formatted['url'] = (String) route('api.v1.services.show', ['id' => $service->id]);
                $new_service_record_formatted['date'] = (String) $service->created_at;
                $new_service_record_formatted['refNo'] = (String) $service->ref_no;

                $service_records[] = $cs->item($resourceKey, $new_service_record_formatted);
            }

            return [
                'name' => (String) ucfirst($car->nama),
                'type' => (String) ucfirst($car->jenis),
                'licensePlate' => (String) strtoupper($car->no_plat),
                'model' => (String) ucfirst($car->model),
                'customer' => $customer,
                'serviceRecords' => $service_records,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.cars.show', ['id' => $car->id]),
                'name' => (String) ucfirst($car->nama),
                'type' => (String) ucfirst($car->jenis),
                'licensePlate' => (String) strtoupper($car->no_plat),
                'model' => (String) ucfirst($car->model),
                'customer' => $customer,
            ];
        }
    }
}
