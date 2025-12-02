<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::with('categoria');

        // filtro por busqueda de nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        // filtro por categoria
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        $productos = $query->orderBy('nombre', 'asc')->get();
        $categorias = Categoria::orderBy('nombre', 'asc')->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'costo' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'categoria_id.required' => 'Debes seleccionar una categoría',
            'categoria_id.exists' => 'La categoría seleccionada no existe',
            'costo.required' => 'El costo es obligatorio',
            'costo.numeric' => 'El costo debe ser un número',
            'costo.min' => 'El costo no puede ser negativo',
            'precio.required' => 'El precio de venta es obligatorio',
            'precio.numeric' => 'El precio debe ser un número',
            'precio.min' => 'El precio no puede ser negativo',
            'stock.required' => 'El stock es obligatorio',
            'stock.integer' => 'El stock debe ser un número entero',
            'stock.min' => 'El stock no puede ser negativo',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o gif',
            'imagen.max' => 'La imagen no puede pesar más de 2MB',
        ]);

        // Preparar datos para crear
        $data = [
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'costo' => $request->costo,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
        ];

        // Manejar la subida de imagen si existe
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $ruta = $imagen->storeAs('productos', $nombreImagen, 'public');
            $data['imagen'] = $ruta;
        }

        // Crear el producto
        Producto::create($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::orderBy('nombre', 'asc')->get();

        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'costo' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'categoria_id.required' => 'Debes seleccionar una categoría',
            'categoria_id.exists' => 'La categoría seleccionada no existe',
            'costo.required' => 'El costo es obligatorio',
            'costo.numeric' => 'El costo debe ser un número',
            'precio.required' => 'El precio de venta es obligatorio',
            'precio.numeric' => 'El precio debe ser un número',
            'stock.required' => 'El stock es obligatorio',
            'stock.integer' => 'El stock debe ser un número entero',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o gif',
            'imagen.max' => 'La imagen no puede pesar más de 2MB',
        ]);

        // Preparar datos para actualizar
        $data = [
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'costo' => $request->costo,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
        ];

        // Manejar la nueva imagen si se subio una
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            // Guardar la nueva imagen
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $ruta = $imagen->storeAs('productos', $nombreImagen, 'public');
            $data['imagen'] = $ruta;
        }

        // Actualizar el producto
        $producto->update($data);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);

        // Eliminar la imagen si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        // Eliminar el producto
        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
