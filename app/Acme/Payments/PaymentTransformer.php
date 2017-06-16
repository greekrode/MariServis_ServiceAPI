<?php

namespace App\Acme\Payments;

use League\Fractal\TransformerAbstract;

use App\Payment;

class PaymentTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Payment $payment) {

        if($this->total == 1) {
            return [
                'method' => $payment->metode_pembayaran,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.payments.show', ['id' => $payment->id]),
                'method' => $payment->metode_pembayaran,
            ];
        }
    }
}
