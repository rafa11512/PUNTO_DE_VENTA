<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'cliente_id', 'usuario_id', 'total', 'fecha', 'metodo_pago'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario() {
        return $this->belongsTo(Usuario::class);
    }

    public function detalles() {
        return $this->hasMany(DetalleVenta::class);
    }
}
