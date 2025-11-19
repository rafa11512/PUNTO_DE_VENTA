<?php

use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $productos = Producto::all();
    $clientes  = Cliente::all();

    return view('welcome', compact('productos', 'clientes'));

})->name('view_home');





/*MODELS
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $connection = 'pgsql';                                   //usar la segunda conexión PostgreSQL
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    public $timestamps = false;                                        //si tu tabla no tiene created_at/updated_at
    protected $fillable = ['nombre','correo','telefono'];         //campos editables
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $connection = 'pgsql';                                   //usar la segunda conexión PostgreSQL
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = false;                                        //si tu tabla no tiene created_at/updated_at
    protected $fillable = ['nombre','precio','stock'];         //campos editables
}
*/