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

        DB::table('empleados')->insert([
            'id' => 272,
            'nombres' => 'Ruben Fuentes'
        ]);

        DB::table('empleados')->insert([
            'id' => 1541,
            'nombres' => 'Justina Paredes'
        ]);

        DB::table('empleados')->insert([
            'id' => 1542,
            'nombres' => 'Justina Pari'
        ]);
    }
}
