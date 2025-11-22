<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importamos el modelo User
use Illuminate\Support\Facades\Hash;

//FUNCIONES PARA LA GESTION DE CLIENTES DESDE EL ADMIN EN EL DASHBOARD  
class AdminClientController extends Controller
{
    //MOSTRAR LISTADO DE CLIENTES
    public function index()
    {
        // Solo traemos a los usuarios que tengan rol 'cliente'
        $clientes = User::where('rol', 'cliente')->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    //MOSTRAR FORMULARIO DE CREAR NUEVO CLIENTE
    public function create()
    {
        return view('admin.clientes.create');
    }

    //GUARDAR NUEVO CLIENTE EN LA BD
    public function store(Request $request)
    {
        // Validamos
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
        ]);

        // Creamos
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptamos contraseña
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'rol' => 'cliente', // Forzamos que sea cliente
        ]);

        // Redirigimos a lA lista de lientes con un mensaje de exito
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente registrado correctamente.');
    }
    
    //MOSTRAR FORMULARIO DE EDICION DE CLIENTE
    public function edit($id)
    {
        // Buscamos al cliente por su ID
        $cliente = User::findOrFail($id);
        return view('admin.clientes.edit', compact('cliente'));
    }

    //ACTUALIZAR CLIENTE EN LA BD
    public function update(Request $request, $id)
    {
        $cliente = User::findOrFail($id);

        // Validamos (el email debe ser unico pero ignorando al usuario actual)
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'telefono' => 'nullable',
            'direccion' => 'nullable',
        ]);

        // preparamos los datos a actualizar
        $datos = [
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ];

        // solo actualizamos la contraseña si escribieron algo nuevo
        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        $cliente->update($datos);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    //ELIMINAR CLIENTE
    public function destroy($id)
    {
        $cliente = User::findOrFail($id);
        $cliente->delete();

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}