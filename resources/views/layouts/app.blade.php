<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            .tema-oscuro { background-color: #111827 !important; color: #f9fafb !important; }
            .tema-oscuro header { background-color: #1f2937 !important; }
            .tema-oscuro .bg-white { background-color: #1f2937 !important; color: #f9fafb !important; }
            .tema-oscuro .text-gray-800 { color: #f9fafb !important; }
            .tema-oscuro .text-gray-600 { color: #d1d5db !important; }
            .tema-oscuro .text-gray-500 { color: #9ca3af !important; }
            .tema-oscuro .border { border-color: #374151 !important; }
            .tema-oscuro .bg-gray-100 { background-color: #1f2937 !important; }

            .tema-profesional { background-color: #1e3a5f !important; color: #f0f4f8 !important; }
            .tema-profesional header { background-color: #162d4a !important; }
            .tema-profesional .bg-white { background-color: #1e3a5f !important; color: #f0f4f8 !important; }
            .tema-profesional .text-gray-800 { color: #f0f4f8 !important; }
            .tema-profesional .text-gray-600 { color: #cbd5e0 !important; }
            .tema-profesional .text-gray-500 { color: #a0aec0 !important; }
            .tema-profesional .border { border-color: #2d5a8e !important; }
            .tema-profesional .bg-gray-100 { background-color: #162d4a !important; }
        </style>

        <script>
            (function() {
                const tema = localStorage.getItem('tema') || 'claro';
                if (tema === 'oscuro') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div id="contenedor-principal" class="min-h-screen bg-gray-100 dark:bg-blue-50 transition-colors duration-300">
            @livewire('navigation-menu')

            @if (isset($header))
                <header class="bg-white dark:bg-blue-100 shadow transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts

        <script>
            (function() {
                const tema       = localStorage.getItem('tema') || 'claro';
                const contenedor = document.getElementById('contenedor-principal');
                if (tema === 'oscuro_total') {
                    contenedor.classList.add('tema-oscuro');
                    document.documentElement.classList.add('dark');
                } else if (tema === 'profesional') {
                    contenedor.classList.add('tema-profesional');
                } else if (tema === 'oscuro') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </body>
</html>