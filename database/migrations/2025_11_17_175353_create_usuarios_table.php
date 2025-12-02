<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // Id
        $table->string('name'); // Nombre (Laravel usa 'name' por defecto)
        $table->string('email')->unique(); // Email (Laravel usa 'email' por defecto)
        $table->string('password'); // Contraseña/Password        
        $table->string('telefono')->nullable(); // Telefono
        $table->text('direccion')->nullable(); // Direccion        
        // Rol: si es admin o cliente
        $table->enum('rol', ['admin', 'cliente'])->default('cliente'); 
        
        $table->timestamps(); // Fecha_creacion (created_at)
    });
}

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
