<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->float('stock');

            $table->integer('revisor_id')->unsigned();
            $table->foreign('revisor_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('items_pedidos_id')->unsigned()->nullable()->default(null);
            $table->foreign('items_pedidos_id')->references('id')->on('items_pedidos')
                ->onDelete('cascade');

            $table->integer('items_temporales_pedidos_id')->unsigned()->nullable()->default(null);
            $table->foreign('items_temporales_pedidos_id')->references('id')->on('items_temporales_pedidos')
                ->onDelete('cascade');

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
        Schema::dropIfExists('control_stock');
    }
}
