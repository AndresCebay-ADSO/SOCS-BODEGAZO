<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Categoria::updateOrCreate(
            ['nomCat' => 'Hombres'],
            ['desCat' => 'Productos para hombres', 'estCat' => 'Activo']
        );
        
        \App\Models\Categoria::updateOrCreate(
            ['nomCat' => 'Mujeres'],
            ['desCat' => 'Productos para mujeres', 'estCat' => 'Activo']
        );
        
        \App\Models\Categoria::updateOrCreate(
            ['nomCat' => 'Niños'],
            ['desCat' => 'Productos para niños', 'estCat' => 'Activo']
        );

        \App\Models\Categoria::updateOrCreate(
            ['nomCat' => 'Deportivos'],
            ['desCat' => 'Productos deportivos', 'estCat' => 'Activo']
        );

        \App\Models\Categoria::updateOrCreate(
            ['nomCat' => 'Formales'],
            ['desCat' => 'Productos formales', 'estCat' => 'Activo']
        );

        \App\Models\Categoria::updateOrCreate(
            ['nomCat' => 'Casuales'],
            ['desCat' => 'Productos casuales', 'estCat' => 'Activo']
        );
    }
}
