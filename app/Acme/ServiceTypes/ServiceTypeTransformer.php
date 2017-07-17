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
            $department = [
                'url' => route('api.v1.departments.show', ['id' => $serviceType->department->id]),
                'name' => ucfirst($serviceType->department->nama),
            ];

            return [
                'name' => ucfirst($serviceType->nama),
                'charge' => $serviceType->biaya,
                'department' => $department,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.service_types.show', ['id' => $serviceType->id]),
                'name' => ucfirst($serviceType->nama),
            ];
        }
    }
}
