<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'costo', 'stock', 'descripcion', 'categoria_id'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function detalles() {
        return $this->hasMany(DetalleVenta::class, 'product_id');
    }
}
