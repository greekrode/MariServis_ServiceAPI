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
            $inventories = [];

            foreach ($category->inventories as $inventory) {
                $cs = new CustomSerializer();
                $resourceKey = "inventory";

                $inventories[] = $cs->item($resourceKey, $inventory->toArray());
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
