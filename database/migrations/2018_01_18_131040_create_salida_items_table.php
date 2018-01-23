<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalidaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->float('cantidad');

            $table->integer('item_pedido_entregado_id')->unsigned();
            $table->foreign('item_pedido_entregado_id')->references('id')->on('items_pedido_entregado')
                ->onDelete('cascade');

            $table->integer('salida_id')->unsigned();
            $table->foreign('salida_id')->references('id')->on('salida_almacen')
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
        Schema::dropIfExists('salida_items');
    }
}
