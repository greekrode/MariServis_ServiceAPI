<?php

use Illuminate\Database\Seeder;

class InventoryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\InventoryService::class, 10)->create();
    }
}
