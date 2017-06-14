<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cars')->insert([
            'no plat' => 'BK 1450 UG',
            'model' =>  'Kijang Innova',
            'tahun' => '2015',
            'tipe' => 'G Diesel',
            'transmisi' => 'Automatic'
        ]);
    }
}
