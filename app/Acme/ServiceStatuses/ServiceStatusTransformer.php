<?php

namespace App\Acme\ServiceStatuses;

use League\Fractal\TransformerAbstract;

use App\ServiceStatus;
use App\Extensions\Serializers\CustomSerializer;

class ServiceStatusTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(ServiceStatus $serviceStatus) {

        if($this->total == 1) {
            $cs = new CustomSerializer();
            $services = array();
            $new_service_formatted = array();

            foreach ($serviceStatus->services as $service) {
                $resourceKey = "service";

                // formatted
                $new_service_formatted['url'] = route('api.v1.services.show', ['id' => $service->id]);
                $new_service_formatted['date'] = (String) $service->created_at;
                $new_service_formatted['refNo'] = $service->ref_no;

                $services[] = $cs->item($resourceKey, $new_service_formatted);
            }

            return [
                'name' => ucfirst($serviceStatus->nama),
                'services' => $services,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.service_statuses.show', ['id' => $serviceStatus->id]),
                'name' => ucfirst($serviceStatus->nama),
            ];
        }
    }
}
