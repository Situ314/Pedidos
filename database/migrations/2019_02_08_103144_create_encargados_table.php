<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncargadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encargados', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->tinyInteger('exclusivo')->default('1');
            $table->integer('tipo_compra_id')->unsigned();
            $table->foreign('tipo_compra_id')->references('id')->on('tipo_compras')
                ->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('encargados');
    }
}
