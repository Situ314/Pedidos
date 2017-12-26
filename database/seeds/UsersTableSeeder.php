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
        DB::table('users')->insert([ //1
            'username' => 'root',
            'email' => null,
            'password' => bcrypt('r00tp3d1d0s'),
            'empleado_id' => 0,
            'rol_id' => 1
        ]);

        DB::table('users')->insert([ //2
            'username' => 'djauregui',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 637,
            'rol_id' => 1
        ]);

        DB::table('users')->insert([ //3
            'username' => 'aut1',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 1,
            'rol_id' => 5
        ]);

        DB::table('users')->insert([ //4
            'username' => 'aut2',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 2,
            'rol_id' => 5
        ]);

        DB::table('users')->insert([ //5
            'username' => 'usu1',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 3,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //6
            'username' => 'usu2',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 4,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //7
            'username' => 'usu3',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 5,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //8
            'username' => 'usu4',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 6,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //9
            'username' => 'usu5',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 7,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //10
            'username' => 'usu6',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 8,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //11
            'username' => 'asi1',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 9,
            'rol_id' => 3
        ]);

        DB::table('users')->insert([ //12
            'username' => 'res1',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 10,
            'rol_id' => 4
        ]);

        DB::table('users')->insert([ //13
            'username' => 'res2',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 11,
            'rol_id' => 4
        ]);
    }
}
