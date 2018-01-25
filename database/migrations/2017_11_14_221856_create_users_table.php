<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique()->default(null);
            $table->string('password');

            $table->integer('empleado_id')->nullable()->unsigned()
//            $table->foreign('empleado_id')->references('id')->on('empleados')
                ->onDelete('cascade');

            $table->integer('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('roles')
                ->onDelete('cascade');

            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
