<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; //modelo User
use Illuminate\Support\Facades\Hash; // Hash para encriptar contraseña

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //ADMINISTRADOR
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@prueba.com',
            'password' => Hash::make('123456'), // Contraseña encriptada
            'rol' => 'admin',
            'telefono' => '33333-44444',
            'direccion' => 'SI',
        ]);

        //CLIENTE
        User::create([
            'name' => 'Juan',
            'email' => 'cliente@prueba.com',
            'password' => Hash::make('123456'),
            'rol' => 'cliente',
            'telefono' => '55555-66666',
            'direccion' => 'SI',
        ]);
    }
}