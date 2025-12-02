<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las categorias con el conteo de productos
        $categorias = Categoria::withCount('productos')->orderBy('nombre', 'asc')->get();

        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio',
            'nombre.unique' => 'Ya existe una categoría con este nombre',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o gif',
            'imagen.max' => 'La imagen no puede pesar más de 2MB',
        ]);

        // Preparar datos para crear
        $data = [
            'nombre' => $request->nombre,
        ];

        // Manejar la subida de imagen si existe
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $ruta = $imagen->storeAs('categorias', $nombreImagen, 'public');
            $data['imagen'] = $ruta;
        }

        // Crear la categoria
        Categoria::create($data);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //mostrar detalle de la categoria con sus productos
        $categoria = Categoria::with('productos')->findOrFail($id);

        return view('admin.categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Obtener la categoria con el conteo de productos
        $categoria = Categoria::withCount('productos')->findOrFail($id);

        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::findOrFail($id);

        // Validar los datos (ignoramoa el nombre actual en la validacion de unique)
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $id,
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio',
            'nombre.unique' => 'Ya existe otra categoría con este nombre',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o gif',
            'imagen.max' => 'La imagen no puede pesar más de 2MB',
        ]);

        // Preparar datos para actualizar
        $data = [
            'nombre' => $request->nombre,
        ];

        // Manejar la nueva imagen si se subio
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($categoria->imagen && Storage::disk('public')->exists($categoria->imagen)) {
                Storage::disk('public')->delete($categoria->imagen);
            }

            // Guardar la nueva imagen
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $ruta = $imagen->storeAs('categorias', $nombreImagen, 'public');
            $data['imagen'] = $ruta;
        }

        // Actualizar la categoria
        $categoria->update($data);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);

        // Verificar si tiene productos asociados
        $cantidadProductos = $categoria->productos()->count();

        if ($cantidadProductos > 0) {
            // No permitir eliminar si tiene productos
            return redirect()->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene ' . $cantidadProductos . ' producto(s) asociado(s)');
        }

        // Eliminar la imagen si existe
        if ($categoria->imagen && Storage::disk('public')->exists($categoria->imagen)) {
            Storage::disk('public')->delete($categoria->imagen);
        }

        // Eliminar la categoria
        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }
}
