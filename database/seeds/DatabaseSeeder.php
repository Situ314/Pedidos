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
        //DATOS DE USUARIOS MAS TABLA DE RESPONSABLES
//        $this->call(EmpleadosTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
//        $this->call(ResponsablessTableSeeder::class);

        //DATOS NECESARIOS PARA LOS ITEMS
        $this->call(TipoCategoriasTableSeeder::class);
        $this->call(CategoriasTableSeeder::class);
        $this->call(UnidadesTableSeeder::class);

        $this->call(ItemsTableSeeder::class);

        //DATOS PARA LOS PEDIDOS
        $this->call(EstadosTableSeeder::class);

        //DATOS PARA LOS PEDIDOS
        $this->call(TipoDocumentosTableSeeder::class);
//        $this->call(EmpresasTableSeeder::class);
//        $this->call(ProyectosTableSeeder::class);

        //PROYECTOS A LOS QUE PERTENECEN LOS USUARIOS
//        $this->call(ProyectosUsersTableSeeder::class);
    }
}
