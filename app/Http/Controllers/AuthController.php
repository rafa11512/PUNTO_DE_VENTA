<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // --- FUNCIONES DE LOGIN Y LOGOUT ---

    //MOSTRAR EL FORMULARIO DE LOGIN
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //PROCESAR EL LOGIN
    public function login(Request $request)
    {
        // Validamos los datos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos loguear
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // OBTENEMOS EL USUARIO LOGUEADO
            $user = Auth::user();

            // --- LOGICA DE REDIRECCIÓN ---
            if ($user->rol === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('client.home');
            }
        }

        // Si falla
        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }



    //PROCESAR EL LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }



    //MOSTRAR EL FORMULARIO DE REGISTRO
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //PROCESAR EL REGISTRO
    public function register(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Creamos el usuario (siempre rol 'cliente' desde aqui)
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'rol' => 'cliente',
        ]);

        return redirect()->route('login')->with('success', '¡Cuenta creada con exito! Por favor inicia sesion.');
    }
}
