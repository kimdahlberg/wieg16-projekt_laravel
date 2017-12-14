<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('qty',12, 4)->nullable();
            $table->decimal('price',12, 4)->nullable();
            $table->decimal('tax_amount',12, 4)->nullable();
            $table->decimal('row_total', 12, 4)->nullable();
            $table->decimal('price_incl_tax', 12, 4)->nullable();
            $table->decimal('total_incl_tax', 12 ,4)->nullable();
            $table->decimal('tax_percent', 12 ,4)->nullable();
            $table->bigInteger('amount_package', false ,true)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
