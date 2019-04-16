<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoComprasIdToItemsTemporalesPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_temporales_pedidos', function (Blueprint $table) {
            $table->integer('tipo_compra_id')->unsigned()->after('item_temp_id')->nullable()->default(null);
            $table->foreign('tipo_compra_id')->references('id')->on('tipo_compras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_temporales_pedidos', function (Blueprint $table) {
            $table->dropForeign('items_temporales_pedidos_tipo_compra_id_foreign');
        });
    }
}
