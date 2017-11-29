<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('email')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('customer_activated')->nullable();
            $table->tinyInteger('group_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('customer_company')->nullable();
            $table->integer('default_billing')->nullable();
            $table->integer('default_shipping')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->string('customer_extra_text')->nullable();
            $table->integer('customer_due_date_period')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}


