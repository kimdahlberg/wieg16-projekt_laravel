<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('entity_id')->primary();
            $table->unsignedBigInteger('entity_type_id')->nullable();
            $table->unsignedBigInteger('attribute_set_id')->nullable();
            $table->string('type_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('has_options')->nullable();
            $table->string('required_options')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('status')->nullable();
            $table->string('name')->nullable();
            $table->integer('amount_package')->nullable();
            $table->decimal('price', 12, 4)->nullable();
            $table->integer('is_salable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
