<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'root',
            'email' => null,
            'password' => bcrypt('r00tp3d1d0s'),
            'empleado_id' => 0,
            'rol_id' => 1
        ]);

        DB::table('users')->insert([
            'username' => 'djauregui',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 637,
            'rol_id' => 1
        ]);

        DB::table('users')->insert([
            'username' => 'aut1',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 1,
            'rol_id' => 5
        ]);

        DB::table('users')->insert([
            'username' => 'aut2',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 2,
            'rol_id' => 5
        ]);

        DB::table('users')->insert([
            'username' => 'usu1',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 3,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([
            'username' => 'usu2',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 4,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([
            'username' => 'usu3',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 5,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([
            'username' => 'usu4',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 6,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([
            'username' => 'usu5',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 7,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([
            'username' => 'usu6',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 8,
            'rol_id' => 6
        ]);
    }
}
