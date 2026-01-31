<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-100 shadow min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between">
            <h1 class="font-bold text-xl">🚀 Livewire CRUD</h1>
            <div class="space-x-4">
                <a href="/" class="text-gray-700 hover:text-blue-600">Inicio</a>
                <a href="{{ route('places.index') }}" class="text-gray-700 hover:text-blue-600">Sitios</a>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="max-w-7xl mx-auto py-8 px-4 flex-1">
        {{ $slot }}
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-500">
            © {{ date('Y') }} - Hecho con Laravel & Livewire
        </div>
    </footer>

    @livewireScripts
</body>

</html>
