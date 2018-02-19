<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->string('codigo',8)->unique();
//            $table->integer('num_solicitud')->nullable()->default(null)->unsigned();

            /*$table->integer('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('areas')
                ->onDelete('cascade');*/

            $table->integer('proyecto_id')->unsigned()
//            $table->foreign('proyecto_id')->references('id')->on('proyectos')
                ->onDelete('cascade');

            $table->integer('tipo_categoria_id')->unsigned();
            $table->foreign('tipo_categoria_id')->references('id')->on('tipo_categorias')
                ->onDelete('cascade');

            $table->integer('solicitante_id')->unsigned();
            $table->foreign('solicitante_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('solicitud_id')->unsigned()->nullable()->default(null);

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
        Schema::dropIfExists('pedidos');
    }
}
