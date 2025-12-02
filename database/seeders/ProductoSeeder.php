<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtenemos los IDs de las categorias creadas previamente
        $catElotes = Categoria::where('nombre', 'Elotes Tradicionales')->first()->id;
        $catEsquites = Categoria::where('nombre', 'Esquites y Vasos')->first()->id;
        $catBotanas = Categoria::where('nombre', 'Botanas Preparadas')->first()->id;
        $catBebidas = Categoria::where('nombre', 'Bebidas Refrescantes')->first()->id;

        // Lista de productos variados
        $productos = [
            // Elotes
            [
                'nombre' => 'Elote Entero Clasico',
                'costo' => 15.00,
                'precio' => 35.00,
                'stock' => 50,
                'descripcion' => 'Elote tierno cocido con mayonesa, queso cotija y chile del que pica o del que no pica.',
                'categoria_id' => $catElotes
            ],
            [
                'nombre' => 'Elote Asado al Carbón',
                'costo' => 15.00,
                'precio' => 40.00,
                'stock' => 30,
                'descripcion' => 'Elote dorado a las brasas, acompañado de limón y sal de grano.',
                'categoria_id' => $catElotes
            ],
            // Esquites
            [
                'nombre' => 'Esquite Vaso Chico',
                'costo' => 12.00,
                'precio' => 30.00,
                'stock' => 100,
                'descripcion' => 'Vaso de 8oz con grano de elote, caldito de epazote y sus complementos.',
                'categoria_id' => $catEsquites
            ],
            [
                'nombre' => 'Esquite Vaso Grande (Litro)',
                'costo' => 25.00,
                'precio' => 60.00,
                'stock' => 80,
                'descripcion' => 'Para los de buen diente, un litro de esquite preparado.',
                'categoria_id' => $catEsquites
            ],
            [
                'nombre' => 'Choriesquite',
                'costo' => 30.00,
                'precio' => 70.00,
                'stock' => 20,
                'descripcion' => 'La combinación perfecta: Esquite con trozos de chorizo frito.',
                'categoria_id' => $catEsquites
            ],
            // Botanas
            [
                'nombre' => 'Dorielotes',
                'costo' => 35.00,
                'precio' => 80.00,
                'stock' => 40,
                'descripcion' => 'Bolsa de Doritos abierta preparada con esquites, queso amarillo y jalapeños.',
                'categoria_id' => $catBotanas
            ],
            [
                'nombre' => 'Tostielotes Salsa Verde',
                'costo' => 35.00,
                'precio' => 80.00,
                'stock' => 40,
                'descripcion' => 'Tostitos sabor salsa verde preparados con elote y crema.',
                'categoria_id' => $catBotanas
            ],
            // Bebidas
            [
                'nombre' => 'Coca Cola 600ml',
                'costo' => 12.00,
                'precio' => 20.00,
                'stock' => 200,
                'descripcion' => 'Refresco de cola bien frío.',
                'categoria_id' => $catBebidas
            ],
        ];

        foreach ($productos as $prod) {
            Producto::create($prod);
        }
    }
}