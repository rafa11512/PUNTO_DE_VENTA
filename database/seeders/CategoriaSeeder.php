<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::firstOrCreate(['nombre' => 'Elotes Tradicionales']);
        Categoria::firstOrCreate(['nombre' => 'Esquites y Vasos']);
        Categoria::firstOrCreate(['nombre' => 'Botanas Preparadas']);
        Categoria::firstOrCreate(['nombre' => 'Bebidas Refrescantes']);
        Categoria::firstOrCreate(['nombre' => 'Postres Caseros']);
    }
}