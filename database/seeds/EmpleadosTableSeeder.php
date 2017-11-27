<?php

use Illuminate\Database\Seeder;

class EmpleadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empleados')->insert([
            'id' => 637,
            'nombres' => 'Diego Jauregui Salvatierra'
        ]);
    }
}
