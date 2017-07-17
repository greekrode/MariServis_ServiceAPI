<?php

namespace App\Acme\Payments;

use League\Fractal\TransformerAbstract;

use App\Payment;
use App\Extensions\Serializers\CustomSerializer;

class PaymentTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Payment $payment) {

        if($this->total == 1) {
            $cs = new CustomSerializer();
            $services = array();
            $new_service_formatted = array();

            foreach ($payment->services as $service) {
                $resourceKey = "service";

                // formatted
                $new_service_formatted['url'] = route('api.v1.services.show', ['id' => $service->id]);
                $new_service_formatted['date'] = (String) $service->created_at;
                $new_service_formatted['refNo'] = $service->ref_no;

                $services[] = $cs->item($resourceKey, $new_service_formatted);
            }

            return [
                'method' => ucfirst($payment->metode_pembayaran),
                'services' => $services
            ];
        } else {
            return [
                'url' => (String) route('api.v1.payments.show', ['id' => $payment->id]),
                'method' => ucfirst($payment->metode_pembayaran),
            ];
        }
    }
}
