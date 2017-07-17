<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {// PERANTARA inventory-qty san service_id
        Schema::create('inventory_service', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('inventory_id')->default(0)->unsigned();
            $table->integer('service_id')->default(0)->unsigned();
            $table->integer('qty')->default(0)->unsigned();
            $table->decimal('total_harga')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_service');
    }
}
