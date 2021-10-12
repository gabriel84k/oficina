<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Tipo::factory(1)->create([
            'nombre'=>'Administrador',
            'estado' => 1
        ]);
        \App\Models\Tipo::factory(1)->create([
           'nombre'=>'Cliente',
            'estado' => 1
        ]);
        \App\Models\Tipo::factory(1)->create([
           'nombre'=>'Técnico',
            'estado' => 1
        ]);
    }
}
