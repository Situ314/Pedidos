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
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('nombre');
            $table->string('descripcion')->nullable()->default(null);
            $table->float('precio_unitario')->nullable()->default(null);
            $table->string('id_producto_cubo')->nullable()->default(null);

            //CAMPO QUE PERMITE SABER SI EL ITEM PASO POR EL RESPONSABLE Y ESTA CONFIRMADO - ESE SERA SU NOMBRE Y SU UNIDAD
            $table->boolean('confirmado');

            $table->integer('tipo_categoria_id')->unsigned();
            $table->foreign('tipo_categoria_id')->references('id')->on('tipo_categorias')
                ->onDelete('cascade');

            $table->integer('categoria_id')->unsigned()->nullable()->default(null);
            $table->foreign('categoria_id')->references('id')->on('categorias')
                ->onDelete('cascade');

            $table->integer('unidad_id')->unsigned();
            $table->foreign('unidad_id')->references('id')->on('unidades')
                ->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('items');
    }
}
