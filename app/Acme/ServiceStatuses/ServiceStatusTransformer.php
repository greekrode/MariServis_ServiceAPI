<?php

namespace App\Acme\ServiceStatuses;

use League\Fractal\TransformerAbstract;

use App\ServiceStatus;

class ServiceStatusTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(ServiceStatus $serviceStatus) {

        if($this->total == 1) {
            return [
                'name' => $serviceStatus->nama,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.service_statuses.show', ['id' => $serviceStatus->id]),
                'name' => $serviceStatus->nama,
            ];
        }
    }
}
