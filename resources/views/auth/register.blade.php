<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-100 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg border border-slate-200">

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Crear Cuenta</h2>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 p-3 rounded text-sm mb-4 border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:blue-500 focus:border-blue-500 outline-none"
                    placeholder="Tu nombre">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Correo Electronico</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="ejemplo@correo.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Contraseña</label>
                <input type="password" name="password" required
                    class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="Minimo 6 caracteres">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" required
                    class="w-full p-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                    placeholder="Repite la contraseña">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-300 shadow-md">
                Registrarse
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Inicia Sesion</a>
        </div>

    </div>

</body>

</html>
