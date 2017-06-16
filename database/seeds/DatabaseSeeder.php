<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class); // OK
        $this->call(DepartmentSeeder::class); // OK
        $this->call(InventorySeeder::class); // OK
        $this->call(PaymentSeeder::class); // OK
        $this->call(ServiceTypeSeeder::class); // OK
        $this->call(StaffSeeder::class); // OK
        $this->call(TransactionStatusSeeder::class); // OK
        $this->call(ServiceStatusSeeder::class); // OK
        $this->call(UserSeeder::class); // OK
        $this->call(CarSeeder::class); // OK
        $this->call(InventoryServiceSeeder::class); // OK
        $this->call(ServiceSeeder::class); // OK
        $this->call(ServiceStaffSeeder::class); // OK
    }
}
