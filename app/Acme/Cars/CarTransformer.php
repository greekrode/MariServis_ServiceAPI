<?php

namespace App\Acme\Cars;

use League\Fractal\TransformerAbstract;

use App\Car;

class CarTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Car $car) {

        if($this->total == 1) {
            return [
                'nama' => (String) $car->nama,
                'jenis' => (String) $car->jenis,
                'no_plat' => (String) $car->no_plat,
                'model' => (String) $car->model,
                'customer_id' => (Int) $car->customer_id,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.cars.show', ['id' => $car->id]),
                'nama' => (String) $car->nama,
                'jenis' => (String) $car->jenis,
                'no_plat' => (String) $car->no_plat,
                'model' => (String) $car->model,
                'customer_id' => (Int) $car->customer_id,
            ];
        }
    }
}
