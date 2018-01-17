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
            'id' => 0,
            'nombres' => 'Root'
        ]);

        DB::table('empleados')->insert([
            'id' => 637,
            'nombres' => 'Diego Jauregui Salvatierra'
        ]);

        DB::table('empleados')->insert([
            'id' => 1,
            'nombres' => 'Autorizador 1'
        ]);

        DB::table('empleados')->insert([
            'id' => 2,
            'nombres' => 'Autorizador 2'
        ]);

        DB::table('empleados')->insert([
            'id' => 3,
            'nombres' => 'Usuario 1'
        ]);

        DB::table('empleados')->insert([
            'id' => 4,
            'nombres' => 'Usuario 2'
        ]);

        DB::table('empleados')->insert([
            'id' => 5,
            'nombres' => 'Usuario 3'
        ]);

        DB::table('empleados')->insert([
            'id' => 6,
            'nombres' => 'Usuario 4'
        ]);

        DB::table('empleados')->insert([
            'id' => 7,
            'nombres' => 'Usuario 5'
        ]);

        DB::table('empleados')->insert([
            'id' => 8,
            'nombres' => 'Usuario 6'
        ]);

        DB::table('empleados')->insert([
            'id' => 9,
            'nombres' => 'Asignador 1'
        ]);

        DB::table('empleados')->insert([
            'id' => 10,
            'nombres' => 'Responsable 1'
        ]);

        DB::table('empleados')->insert([
            'id' => 11,
            'nombres' => 'Responsable 2'
        ]);

        DB::table('empleados')->insert([
            'id' => 12,
            'nombres' => 'Entrega 1'
        ]);

        DB::table('empleados')->insert([
            'id' => 13,
            'nombres' => 'Entrega 2'
        ]);
    }
}
