<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTemporalesPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_temporales_pedidos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->float('cantidad');

            $table->integer('pedido_id')->unsigned();
            $table->foreign('pedido_id')->references('id')->on('pedidos')
                ->onDelete('cascade');

            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items_temporales')
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
        Schema::dropIfExists('items_temporales_pedidos');
    }
}
