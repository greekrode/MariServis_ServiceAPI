<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ref_no')->index();
            $table->integer('customer_id')->default(0)->index();
            $table->integer('car_id')->index();
            // $table->integer('inventory_id')->index(); // --- MANY TO MANY(attach to third table)
            // $table->integer('service_types_id')->index(); // --- MANY TO MANY(attach to third table)
            $table->integer('payment_id')->unsigned()->index();
            $table->integer('status_transaksi_id')->default(1)->unsigned()->index(); // boolean transaksi pending or sukses?
            $table->integer('status_service_id')->default(1)->unsigned()->index(); // boolean service "dalam perbaikan" or "selesai"
            // $table->decimal('total_biaya')->default(0)->unsigned();
            // array -> total_servis: tipe_servis

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
