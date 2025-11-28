<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'costo','precio', 'stock', 'descripcion', 'categoria_id','imagen'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function detalles() {
        return $this->hasMany(DetalleVenta::class, 'product_id');
    }
}
