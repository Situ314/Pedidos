<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('tabla', 50); // Nombre de la tabla
            $table->string('tipo', 2); // Tipo de registro
            $table->integer('tabla_id'); // Id del registro que se actualiza
            $table->string('tabla_campo', 50)->nullable()->default(null); // Nombre del campo
            $table->string('valor_anterior', 255)->nullable()->default(null); // Valor anterior
            $table->string('valor_nuevo', 255)->nullable()->default(null); // Valor nuevo
            $table->ipAddress('ip'); // Ip del cliente

            // Foreign Key
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('logs');
    }
}
