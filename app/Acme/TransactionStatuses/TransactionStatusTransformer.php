<?php

namespace App\Acme\TransactionStatuses;

use League\Fractal\TransformerAbstract;

use App\TransactionStatus;
use App\Extensions\Serializers\CustomSerializer;

class TransactionStatusTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(TransactionStatus $transactionStatus) {

        if ($this->total == 1) {
            $cs = new CustomSerializer();
            $services = array();
            $new_service_formatted = array();

            foreach ($transactionStatus->services as $service) {
                $resourceKey = "service";

                // formatted
                $new_service_formatted['url'] = route('api.v1.services.show', ['id' => $service->id]);
                $new_service_formatted['date'] = (String) $service->created_at;
                $new_service_formatted['refNo'] = $service->ref_no;

                $services[] = $cs->item($resourceKey, $new_service_formatted);
            }

            return [
                'name' => ucfirst($transactionStatus->nama),
                'services' => $services,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.transaction_statuses.show', ['id' => $transactionStatus->id]),
                'name' => ucfirst($transactionStatus->nama),
            ];
        }
    }
}
