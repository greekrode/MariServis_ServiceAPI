<?php

use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\TransactionStatus::Insert([
            ['nama' => 'pending'],
            ['nama' => 'sukses']
        ]);
    }
}
