<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Venta extends Model
{
    protected $fillable = [
        'cliente_id', 'usuario_id', 'total', 'fecha', 'metodo_pago'
    ];

    public function cliente() {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalles() {
        return $this->hasMany(DetalleVenta::class);
    }
}
