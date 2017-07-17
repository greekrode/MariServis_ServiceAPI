<?php

use Illuminate\Database\Seeder;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\ServiceStatus::Insert([
            ['nama' => 'dalam perbaikan'],
            ['nama' => 'selesai']
        ]);
    }
}
