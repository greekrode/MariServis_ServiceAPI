<?php

namespace App\Acme\TransactionStatuses;

use League\Fractal\TransformerAbstract;

use App\TransactionStatus;

class TransactionStatusTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(TransactionStatus $transactionStatus) {

        if($this->total == 1) {
            return [
                'name' => $transactionStatus->nama,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.transaction_statuses.show', ['id' => $transactionStatus->id]),
                'name' => $transactionStatus->nama,
            ];
        }
    }
}
