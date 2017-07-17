<?php

namespace App\Acme\Categories;

use League\Fractal\TransformerAbstract;
use App\Extensions\Serializers\CustomSerializer;

use App\Category;

class CategoryTransformer extends TransformerAbstract {
    private $total;

    public function __construct($total) {
        $this->total = $total;
    }

    public function transform(Category $category) {

        if($this->total == 1) {
            $cs = new CustomSerializer();
            $inventories = [];

            foreach ($category->inventories->sortBy('id') as $inventory) {
                $resourceKey = "inventory";
                $new_inventory_formatted = array();

                // formatted
                $new_inventory_formatted['url'] = (String) route('api.v1.inventories.show', ['id' => $inventory->id]);
                $new_inventory_formatted['name'] = $inventory->nama;
                // $new_inventory_formatted['price'] = '$' . ((Double) $inventory->harga);
                // $new_inventory_formatted['quantity'] = (Int) $inventory->qty;

                $inventories[] = $cs->item($resourceKey, $new_inventory_formatted);
            }

            return [
                'name' => (String) $category->nama,
                'inventories' => $inventories,
            ];
        } else {

            return [
                'url' => (String) route('api.v1.categories.show', ['id' => $category->id]),
                'name' => (String) $category->nama,
            ];
        }
    }
}
