<?php

namespace App\Acme\ServiceTypes;

use League\Fractal\TransformerAbstract;

use App\ServiceType;

class ServiceTypeTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(ServiceType $serviceType) {

        if($this->total == 1) {
            return [
                'name' => $serviceType->nama,
                'charge' => $serviceType->biaya,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.service_types.show', ['id' => $serviceType->id]),
                'name' => $serviceType->nama,
                'charge' => $serviceType->biaya,
            ];
        }
    }
}
