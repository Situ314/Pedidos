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

         $this->call(UnidadesTableSeeder::class);

         $this->call(ItemsTableSeeder::class);
         $this->call(EstadosTableSeeder::class);

         $this->call(EmpresasTableSeeder::class);
         $this->call(ProyectosTableSeeder::class);

         $this->call(ResponsablessTableSeeder::class);

         $this->call(ProyectosUsersTableSeeder::class);
    }
}
