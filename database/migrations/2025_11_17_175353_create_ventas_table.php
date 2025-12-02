<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
    Schema::create('ventas', function (Blueprint $table) {
        $table->id(); // Id
        
        // Cliente_id (Relacionado con la tabla users)
        $table->foreignId('cliente_id')->constrained('users');
        
        // Usuario_id (El empleado que hizo la venta, puede ser nulo si fue venta web)
        $table->foreignId('usuario_id')->nullable()->constrained('users');
        
        $table->decimal('total', 10, 2); // Total
        $table->string('metodo_pago'); // Metodo_pago
        
        $table->enum('estado', ['pendiente', 'en_preparacion', 'completado', 'cancelado'])
                  ->default('pendiente')
                  ->after('metodo_pago');

        // Fecha (created_at sirve como fecha, pero agregamos una explícita si quieres)
        $table->timestamp('fecha')->useCurrent(); 
        
        $table->timestamps();
    });
}

public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
