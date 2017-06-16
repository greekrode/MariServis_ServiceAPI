<?php

use Illuminate\Database\Seeder;

class ServiceStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ServiceStaff::class, 30)->create();
    }
}
