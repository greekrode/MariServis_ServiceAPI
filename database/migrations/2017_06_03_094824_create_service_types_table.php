<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {// tipe_servis <-> inventory
        Schema::create('service_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nama')->unique();
            $table->decimal('biaya')->unsigned();

            $table->integer('department_id')->default(0)->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_types');
    }
}
