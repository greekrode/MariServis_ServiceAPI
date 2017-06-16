<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Service::class, 10)
       ->create()
       ->each(function ($service) {
            $service->inventories()->save(factory(App\InventoryService::class)->make());
            $service->inventories()->save(factory(App\ServiceServiceType::class)->make());
        });
    }
}
