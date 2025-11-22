<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

public function up()
{
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->decimal('costo', 10, 2);
        $table->decimal('precio', 10, 2); // Agregué precio de venta si faltaba
        $table->integer('stock');
        $table->text('descripcion')->nullable();
        
        // Campo para la imagen del producto
        $table->string('imagen')->nullable(); 
        
        $table->foreignId('categoria_id')->constrained('categorias'); 
        $table->timestamps();
    });
}


    public function down(): void {
        Schema::dropIfExists('productos');
    }
};
