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
            $category = [
                'url' => (String) route('api.v1.categories.show', ['id' => $inventory->category->id]),
                'name' => ucfirst($inventory->category->nama),
            ];

            return [
                'name' => ucfirst($inventory->nama),
                'price' => '$' . (Double) $inventory->harga,
                'quantity' => (Int) $inventory->qty,
                'category' =>  $category,
            ];
        } else {
            return [
                'url' => (String) route('api.v1.inventories.show', ['id' => $inventory->id]),
                'name' => ucfirst($inventory->nama),
                // 'price' => (Int) $inventory->harga,
                // 'quantity' => (Int) $inventory->qty,
                // 'category' => (String) $inventory->category->nama,
            ];
        }
    }
}
