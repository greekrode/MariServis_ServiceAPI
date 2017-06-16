<?php

namespace App\Acme\Inventories;

use League\Fractal\TransformerAbstract;

use App\Inventory;

class InventoryTransformer extends TransformerAbstract
{
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Inventory $inventory) {

        if($this->total == 1) {
            return [
                'name' => $inventory->nama,
                'price' => (Int) $inventory->harga,
                'qty' => (Int) $inventory->qty,
                'category' => (String) $inventory->category->nama,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.inventories.show', ['id' => $inventory->id]),
                'name' => $inventory->nama,
                'price' => (Int) $inventory->harga,
                'qty' => (Int) $inventory->qty,
                'category' => (String) $inventory->category->nama,
            ];
        }
    }
}
