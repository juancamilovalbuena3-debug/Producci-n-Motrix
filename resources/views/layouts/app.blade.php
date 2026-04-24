<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            /* ══════════════════════════════════════
               TEMA FUTURISTA (azul neón)
            ══════════════════════════════════════ */
            .tema-futurista {
                background-color: #03070f !important;
                color: #c8d8f0 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-futurista::after {
                content: '';
                position: fixed;
                inset: 0;
                background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,180,255,.012) 2px, rgba(0,180,255,.012) 4px);
                pointer-events: none;
                z-index: 9999;
            }
            .tema-futurista nav,
            .tema-futurista header {
                background: rgba(0,10,24,.97) !important;
                border-bottom: 1px solid rgba(0,180,255,.18) !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-futurista nav a,
            .tema-futurista header a {
                color: rgba(200,216,240,.7) !important;
                letter-spacing: .04em;
                transition: color .2s;
            }
            .tema-futurista nav a:hover,
            .tema-futurista header a:hover { color: #00b4ff !important; }
            .tema-futurista .bg-white,
            .tema-futurista .bg-gray-100,
            .tema-futurista .bg-gray-50 {
                background: rgba(0,15,35,.85) !important;
                border: 1px solid rgba(0,180,255,.1) !important;
            }
            .tema-futurista .min-h-screen { background: #03070f !important; }
            .tema-futurista h1, .tema-futurista h2,
            .tema-futurista h3, .tema-futurista h4 {
                color: #c8d8f0 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-futurista .text-gray-900,
            .tema-futurista .text-gray-800,
            .tema-futurista .text-black { color: #c8d8f0 !important; }
            .tema-futurista .text-gray-700,
            .tema-futurista .text-gray-600 { color: rgba(200,216,240,.65) !important; }
            .tema-futurista .text-gray-500 { color: rgba(200,216,240,.4) !important; }
            .tema-futurista .border,
            .tema-futurista .border-r,
            .tema-futurista .border-b,
            .tema-futurista .border-t { border-color: rgba(0,180,255,.12) !important; }
            .tema-futurista aside {
                background: rgba(0,10,24,.9) !important;
                border-right: 1px solid rgba(0,180,255,.12) !important;
            }
            .tema-futurista aside a { color: rgba(200,216,240,.6) !important; transition: color .2s, background .2s; }
            .tema-futurista aside a:hover { color: #00b4ff !important; background: rgba(0,180,255,.06) !important; }
            .tema-futurista input, .tema-futurista select, .tema-futurista textarea {
                background: rgba(0,20,50,.7) !important;
                border: 1px solid rgba(0,180,255,.2) !important;
                color: #c8d8f0 !important;
                border-radius: 0 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-futurista input:focus, .tema-futurista select:focus, .tema-futurista textarea:focus {
                outline: none !important;
                border-color: #00b4ff !important;
                box-shadow: 0 0 0 1px rgba(0,180,255,.25) !important;
            }
            .tema-futurista input::placeholder { color: rgba(200,216,240,.3) !important; }
            .tema-futurista button, .tema-futurista .btn {
                font-family: 'Rajdhani', sans-serif !important;
                letter-spacing: .08em !important;
            }
            .tema-futurista button[type="submit"], .tema-futurista .btn-primary {
                background: rgba(0,180,255,.12) !important;
                border: 1px solid rgba(0,180,255,.4) !important;
                color: #00b4ff !important;
                border-radius: 0 !important;
            }
            .tema-futurista button[type="submit"]:hover { background: rgba(0,180,255,.22) !important; }
            .tema-futurista .text-red-600 { color: rgba(255,90,90,.85) !important; }
            .tema-futurista table { border-collapse: collapse; width: 100%; }
            .tema-futurista thead {
                background: rgba(0,180,255,.15) !important;
                border-bottom: 1px solid rgba(0,180,255,.2) !important;
            }
            .tema-futurista th {
                color: #00d4ff !important;
                font-family: 'Orbitron', monospace !important;
                font-size: 12px !important;
                letter-spacing: .14em !important;
                text-transform: uppercase !important;
                padding: 10px 14px !important;
                font-weight: 600 !important;
                border-color: rgba(0,180,255,.2) !important;
            }
            .tema-futurista td {
                padding: 10px 14px !important;
                border-bottom: 1px solid rgba(0,180,255,.06) !important;
                color: #dbeafe !important;
                font-size: 14px !important;
                border-color: rgba(0,180,255,.2) !important;
            }
            .tema-futurista tr:hover td { background: rgba(0,180,255,.12) !important; }
            .tema-futurista .bg-green-100 {
                background: rgba(0,255,157,.06) !important;
                border-color: rgba(0,255,157,.3) !important;
                color: #00ff9d !important;
            }
            .tema-futurista .bg-yellow-50,
            .tema-futurista .bg-red-100 {
                background: rgba(255,60,60,.06) !important;
                border-color: rgba(255,60,60,.3) !important;
                color: rgba(255,120,120,.9) !important;
            }
            .tema-futurista .shadow,
            .tema-futurista .shadow-xl,
            .tema-futurista .shadow-sm { box-shadow: 0 0 0 1px rgba(0,180,255,.1) !important; }
            .tema-futurista .rounded-lg,
            .tema-futurista .rounded,
            .tema-futurista .sm\:rounded-lg { border-radius: 0 !important; }
            .tema-futurista ::-webkit-scrollbar { width: 5px; }
            .tema-futurista ::-webkit-scrollbar-track { background: #03070f; }
            .tema-futurista ::-webkit-scrollbar-thumb { background: rgba(0,180,255,.3); border-radius: 3px; }

            /* ══════════════════════════════════════
               TEMA ROSA (futurista rosado)
            ══════════════════════════════════════ */
            .tema-rosa {
                background-color: #0f0310 !important;
                color: #f0d6f5 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-rosa::after {
                content: '';
                position: fixed;
                inset: 0;
                background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,100,200,.012) 2px, rgba(255,100,200,.012) 4px);
                pointer-events: none;
                z-index: 9999;
            }
            .tema-rosa nav,
            .tema-rosa header {
                background: rgba(24,5,24,.97) !important;
                border-bottom: 1px solid rgba(255,100,200,.18) !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-rosa nav a,
            .tema-rosa header a {
                color: rgba(240,214,245,.7) !important;
                letter-spacing: .04em;
                transition: color .2s;
            }
            .tema-rosa nav a:hover,
            .tema-rosa header a:hover { color: #ff64c8 !important; }
            .tema-rosa .bg-white,
            .tema-rosa .bg-gray-100,
            .tema-rosa .bg-gray-50 {
                background: rgba(35,5,40,.85) !important;
                border: 1px solid rgba(255,100,200,.1) !important;
            }
            .tema-rosa .min-h-screen { background: #0f0310 !important; }
            .tema-rosa h1, .tema-rosa h2,
            .tema-rosa h3, .tema-rosa h4 {
                color: #f0d6f5 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-rosa .text-gray-900,
            .tema-rosa .text-gray-800,
            .tema-rosa .text-black { color: #f0d6f5 !important; }
            .tema-rosa .text-gray-700,
            .tema-rosa .text-gray-600 { color: rgba(240,214,245,.65) !important; }
            .tema-rosa .text-gray-500 { color: rgba(240,214,245,.4) !important; }
            .tema-rosa .border,
            .tema-rosa .border-r,
            .tema-rosa .border-b,
            .tema-rosa .border-t { border-color: rgba(255,100,200,.12) !important; }
            .tema-rosa aside {
                background: rgba(24,5,24,.9) !important;
                border-right: 1px solid rgba(255,100,200,.12) !important;
            }
            .tema-rosa aside a { color: rgba(240,214,245,.6) !important; transition: color .2s, background .2s; }
            .tema-rosa aside a:hover { color: #ff64c8 !important; background: rgba(255,100,200,.06) !important; }
            .tema-rosa input, .tema-rosa select, .tema-rosa textarea {
                background: rgba(50,5,55,.7) !important;
                border: 1px solid rgba(255,100,200,.2) !important;
                color: #f0d6f5 !important;
                border-radius: 0 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-rosa input:focus, .tema-rosa select:focus, .tema-rosa textarea:focus {
                outline: none !important;
                border-color: #ff64c8 !important;
                box-shadow: 0 0 0 1px rgba(255,100,200,.25) !important;
            }
            .tema-rosa input::placeholder { color: rgba(240,214,245,.3) !important; }
            .tema-rosa button, .tema-rosa .btn {
                font-family: 'Rajdhani', sans-serif !important;
                letter-spacing: .08em !important;
            }
            .tema-rosa button[type="submit"], .tema-rosa .btn-primary {
                background: rgba(255,100,200,.12) !important;
                border: 1px solid rgba(255,100,200,.4) !important;
                color: #ff64c8 !important;
                border-radius: 0 !important;
            }
            .tema-rosa button[type="submit"]:hover { background: rgba(255,100,200,.22) !important; }
            .tema-rosa .text-red-600 { color: rgba(255,100,150,.85) !important; }
            .tema-rosa table { border-collapse: collapse; width: 100%; }
            .tema-rosa thead {
                background: rgba(255,100,200,.12) !important;
                border-bottom: 1px solid rgba(255,100,200,.2) !important;
            }
            .tema-rosa th {
                color: #ff64c8 !important;
                font-family: 'Orbitron', monospace !important;
                font-size: 12px !important;
                letter-spacing: .14em !important;
                text-transform: uppercase !important;
                padding: 10px 14px !important;
                font-weight: 600 !important;
                border-color: rgba(255,100,200,.2) !important;
            }
            .tema-rosa td {
                padding: 10px 14px !important;
                border-bottom: 1px solid rgba(255,100,200,.06) !important;
                color: #f0d6f5 !important;
                font-size: 14px !important;
                border-color: rgba(255,100,200,.2) !important;
            }
            .tema-rosa tr:hover td { background: rgba(255,100,200,.08) !important; }
            .tema-rosa .bg-green-100 {
                background: rgba(255,150,220,.06) !important;
                border-color: rgba(255,150,220,.3) !important;
                color: #ffaaee !important;
            }
            .tema-rosa .bg-yellow-50,
            .tema-rosa .bg-red-100 {
                background: rgba(255,60,120,.06) !important;
                border-color: rgba(255,60,120,.3) !important;
                color: rgba(255,120,160,.9) !important;
            }
            .tema-rosa .shadow,
            .tema-rosa .shadow-xl,
            .tema-rosa .shadow-sm { box-shadow: 0 0 0 1px rgba(255,100,200,.1) !important; }
            .tema-rosa .rounded-lg,
            .tema-rosa .rounded,
            .tema-rosa .sm\:rounded-lg { border-radius: 0 !important; }
            .tema-rosa ::-webkit-scrollbar { width: 5px; }
            .tema-rosa ::-webkit-scrollbar-track { background: #0f0310; }
            .tema-rosa ::-webkit-scrollbar-thumb { background: rgba(255,100,200,.3); border-radius: 3px; }

            /* ══════════════════════════════════════
               TEMA BLANCO (futurista claro)
            ══════════════════════════════════════ */
            .tema-blanco {
                background-color: #f0f4fa !important;
                color: #0d1117 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-blanco nav,
            .tema-blanco header {
                background: #ffffff !important;
                border-bottom: 1px solid rgba(0,100,200,.15) !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-blanco nav a,
            .tema-blanco header a {
                color: rgba(13,17,23,.65) !important;
                letter-spacing: .04em;
                transition: color .2s;
            }
            .tema-blanco nav a:hover,
            .tema-blanco header a:hover { color: #0064c8 !important; }
            .tema-blanco .bg-white,
            .tema-blanco .bg-gray-100,
            .tema-blanco .bg-gray-50 {
                background: #ffffff !important;
                border: 1px solid rgba(0,100,200,.1) !important;
            }
            .tema-blanco .min-h-screen { background: #f0f4fa !important; }
            .tema-blanco h1, .tema-blanco h2,
            .tema-blanco h3, .tema-blanco h4 {
                color: #0d1117 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-blanco .text-gray-900,
            .tema-blanco .text-gray-800,
            .tema-blanco .text-black { color: #0d1117 !important; }
            .tema-blanco .text-gray-700,
            .tema-blanco .text-gray-600 { color: rgba(13,17,23,.6) !important; }
            .tema-blanco .text-gray-500 { color: rgba(13,17,23,.4) !important; }
            .tema-blanco .border,
            .tema-blanco .border-r,
            .tema-blanco .border-b,
            .tema-blanco .border-t { border-color: rgba(0,100,200,.1) !important; }
            .tema-blanco aside {
                background: #ffffff !important;
                border-right: 1px solid rgba(0,100,200,.1) !important;
            }
            .tema-blanco aside a { color: rgba(13,17,23,.55) !important; transition: color .2s, background .2s; }
            .tema-blanco aside a:hover { color: #0064c8 !important; background: rgba(0,100,200,.05) !important; }
            .tema-blanco input, .tema-blanco select, .tema-blanco textarea {
                background: #f8faff !important;
                border: 1px solid rgba(0,100,200,.2) !important;
                color: #0d1117 !important;
                border-radius: 0 !important;
                font-family: 'Rajdhani', sans-serif !important;
            }
            .tema-blanco input:focus, .tema-blanco select:focus, .tema-blanco textarea:focus {
                outline: none !important;
                border-color: #0064c8 !important;
                box-shadow: 0 0 0 1px rgba(0,100,200,.2) !important;
            }
            .tema-blanco input::placeholder { color: rgba(13,17,23,.3) !important; }
            .tema-blanco button, .tema-blanco .btn {
                font-family: 'Rajdhani', sans-serif !important;
                letter-spacing: .08em !important;
            }
            .tema-blanco button[type="submit"], .tema-blanco .btn-primary {
                background: rgba(0,100,200,.08) !important;
                border: 1px solid rgba(0,100,200,.35) !important;
                color: #0064c8 !important;
                border-radius: 0 !important;
            }
            .tema-blanco button[type="submit"]:hover { background: rgba(0,100,200,.15) !important; }
            .tema-blanco .text-red-600 { color: #cc2200 !important; }
            .tema-blanco table { border-collapse: collapse; width: 100%; }
            .tema-blanco thead {
                background: rgba(0,100,200,.06) !important;
                border-bottom: 1px solid rgba(0,100,200,.15) !important;
            }
            .tema-blanco th {
                color: #0064c8 !important;
                font-family: 'Orbitron', monospace !important;
                font-size: 12px !important;
                letter-spacing: .14em !important;
                text-transform: uppercase !important;
                padding: 10px 14px !important;
                font-weight: 600 !important;
                border-color: rgba(0,100,200,.15) !important;
            }
            .tema-blanco td {
                padding: 10px 14px !important;
                border-bottom: 1px solid rgba(0,100,200,.06) !important;
                color: #0d1117 !important;
                font-size: 14px !important;
                border-color: rgba(0,100,200,.1) !important;
            }
            .tema-blanco tr:hover td { background: rgba(0,100,200,.04) !important; }
            .tema-blanco .bg-green-100 {
                background: rgba(0,180,100,.08) !important;
                border-color: rgba(0,180,100,.3) !important;
                color: #006630 !important;
            }
            .tema-blanco .bg-yellow-50,
            .tema-blanco .bg-red-100 {
                background: rgba(220,50,0,.06) !important;
                border-color: rgba(220,50,0,.25) !important;
                color: #cc2200 !important;
            }
            .tema-blanco .shadow,
            .tema-blanco .shadow-xl,
            .tema-blanco .shadow-sm { box-shadow: 0 1px 3px rgba(0,100,200,.08) !important; }
            .tema-blanco .rounded-lg,
            .tema-blanco .rounded,
            .tema-blanco .sm\:rounded-lg { border-radius: 0 !important; }
            .tema-blanco ::-webkit-scrollbar { width: 5px; }
            .tema-blanco ::-webkit-scrollbar-track { background: #f0f4fa; }
            .tema-blanco ::-webkit-scrollbar-thumb { background: rgba(0,100,200,.2); border-radius: 3px; }

            /* ── TEMAS ORIGINALES ── */
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
                const tema       = localStorage.getItem('tema') || 'futurista';
                const html       = document.documentElement;
                const temasCss   = ['tema-futurista','tema-rosa','tema-blanco','tema-oscuro','tema-profesional'];

                html.classList.remove(...temasCss, 'dark');

                if (tema === 'futurista') {
                    html.classList.add('tema-futurista', 'dark');
                } else if (tema === 'rosa') {
                    html.classList.add('tema-rosa', 'dark');
                } else if (tema === 'blanco') {
                    html.classList.add('tema-blanco');
                } else if (tema === 'oscuro_total') {
                    html.classList.add('tema-oscuro', 'dark');
                } else if (tema === 'profesional') {
                    html.classList.add('tema-profesional');
                } else if (tema === 'oscuro') {
                    html.classList.add('dark');
                }
            })();
        </script>
    </head>

    <body class="font-sans antialiased">
        <x-banner />

        <div id="contenedor-principal" class="min-h-screen transition-colors duration-300">
            @livewire('navigation-menu')

            @if (isset($header))
                <header class="shadow transition-colors duration-300">
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
                const tema       = localStorage.getItem('tema') || 'futurista';
                const contenedor = document.getElementById('contenedor-principal');
                const temasCss   = ['tema-futurista','tema-rosa','tema-blanco','tema-oscuro','tema-profesional'];

                if (contenedor) contenedor.classList.remove(...temasCss);
                document.documentElement.classList.remove('dark');

                if (tema === 'futurista') {
                    if (contenedor) contenedor.classList.add('tema-futurista');
                    document.documentElement.classList.add('dark');
                } else if (tema === 'rosa') {
                    if (contenedor) contenedor.classList.add('tema-rosa');
                    document.documentElement.classList.add('dark');
                } else if (tema === 'blanco') {
                    if (contenedor) contenedor.classList.add('tema-blanco');
                } else if (tema === 'oscuro_total') {
                    if (contenedor) contenedor.classList.add('tema-oscuro');
                    document.documentElement.classList.add('dark');
                } else if (tema === 'profesional') {
                    if (contenedor) contenedor.classList.add('tema-profesional');
                } else if (tema === 'oscuro') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </body>
</html>