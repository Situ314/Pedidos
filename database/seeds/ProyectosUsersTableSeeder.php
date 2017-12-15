<?php

use Illuminate\Database\Seeder;

class ProyectosUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proyectos_users')->insert([
            'proyecto_id' => 1,
            'user_id' =>1
        ]);
        DB::table('proyectos_users')->insert([
            'proyecto_id' => 2,
            'user_id' =>2
        ]);
        DB::table('proyectos_users')->insert([
            'proyecto_id' => 3,
            'user_id' =>2
        ]);

        DB::table('proyectos_users')->insert([
            'proyecto_id' => 40,
            'user_id' =>5
        ]);
        DB::table('proyectos_users')->insert([
            'proyecto_id' => 41,
            'user_id' =>5
        ]);

        DB::table('proyectos_users')->insert([
            'proyecto_id' => 78,
            'user_id' =>6
        ]);

        DB::table('proyectos_users')->insert([
            'proyecto_id' => 110,
            'user_id' =>7
        ]);

        DB::table('proyectos_users')->insert([
            'proyecto_id' => 125,
            'user_id' =>8
        ]);

        DB::table('proyectos_users')->insert([
            'proyecto_id' => 23,
            'user_id' =>9
        ]);
    }
}
