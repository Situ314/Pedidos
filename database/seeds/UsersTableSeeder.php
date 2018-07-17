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
            'password' => bcrypt('r00tp3d1d0s'),
            'empleado_id' => null,
            'rol_id' => 1
        ]);

        DB::table('users')->insert([ //2
            'username' => 'admin',
            'password' => bcrypt('adminpedidos123%'),
            'empleado_id' => null,
            'rol_id' => 2
        ]);

        /*DB::table('users')->insert([ //2
            'username' => 'aut1',
            'password' => bcrypt('123'),
            'empleado_id' => 1,
            'rol_id' => 5
        ]);

        DB::table('users')->insert([ //3
            'username' => 'aut2',
            'password' => bcrypt('123'),
            'empleado_id' => 2,
            'rol_id' => 5
        ]);

        DB::table('users')->insert([ //4
            'username' => 'usu1',
            'password' => bcrypt('123'),
            'empleado_id' => 3,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //5
            'username' => 'usu2',
            'password' => bcrypt('123'),
            'empleado_id' => 4,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //6
            'username' => 'usu3',
            'password' => bcrypt('123'),
            'empleado_id' => 5,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //7
            'username' => 'usu4',
            'password' => bcrypt('123'),
            'empleado_id' => 6,
            'rol_id' => 6
        ]);

        DB::table('users')->insert([ //8
            'username' => 'res1',
            'password' => bcrypt('123'),
            'empleado_id' => 7,
            'rol_id' => 4
        ]);

        DB::table('users')->insert([ //9
            'username' => 'res2',
            'password' => bcrypt('123'),
            'empleado_id' => 8,
            'rol_id' => 4
        ]);

        DB::table('users')->insert([ //11
            'username' => 'asi1',
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

        DB::table('users')->insert([ //14
            'username' => 'rese1',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 12,
            'rol_id' => 7
        ]);

        DB::table('users')->insert([ //15
            'username' => 'rese2',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 13,
            'rol_id' => 7
        ]);*/
    }
}
