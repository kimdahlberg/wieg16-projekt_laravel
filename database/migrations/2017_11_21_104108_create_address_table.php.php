<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public
    function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigInteger('id', false, true);
            $table->bigInteger('customer_id', false, true);
            $table->tinyInteger('customer_address_id')->nullable();
            $table->string('email')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('postcode')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('telephone')->nullable();
            $table->string('country_id')->nullable();
            $table->string('address_type')->nullable();
            $table->string('company')->nullable();
            $table->string('country')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public
    function down()
    {
        Schema::dropIfExists('addresses');
        //
    }
}
