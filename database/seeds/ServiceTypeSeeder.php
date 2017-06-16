<?php

use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\ServiceType::Insert([
            ['nama' => 'Ganti ban',
             'biaya' => 15000],
            ['nama' => 'Ganti oli',
             'biaya' => 5000],
        ]);
    }
}
