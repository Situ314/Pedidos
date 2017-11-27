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
            'username' => 'djauregui',
            'email' => null,
            'password' => bcrypt('123'),
            'empleado_id' => 637,
            'rol_id' => 1
        ]);
    }
}
