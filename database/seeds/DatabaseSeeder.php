<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(EmpleadosTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(UsersTableSeeder::class);

         $this->call(TipoCategoriasTableSeeder::class);
         $this->call(CategoriasTableSeeder::class);

         $this->call(AreasTableSeeder::class);
         $this->call(UnidadesTableSeeder::class);

    }
}
