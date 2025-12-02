<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
    Schema::create('detalle_ventas', function (Blueprint $table) {
        $table->id(); // id
        
        // venta_id (Si se borra la venta, se borran los detalles)
        $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');
        
        // product_id (Relacion con productos)
        $table->foreignId('producto_id')->constrained('productos');
        
        $table->integer('cantidad'); // cantidad
        $table->decimal('precio_unitario', 10, 2); // precio_unitario
        $table->decimal('subtotal', 10, 2); // subtotal
        
        $table->timestamps();
    });
}

    public function down(): void {
        Schema::dropIfExists('detalle_ventas');
    }
};
