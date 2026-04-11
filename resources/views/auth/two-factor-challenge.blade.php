<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motrix – Verificación</title>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:    #0b1f3a;
            --blue:    #1a3a6e;
            --accent:  #1d4ed8;
            --silver:  #c8d6e8;
            --chrome:  #e8eef6;
            --white:   #ffffff;
            --gray:    #6b7a8f;
            --light:   #f4f7fb;
        }

        body {
            min-height: 100vh;
            font-family: 'Lato', sans-serif;
            background: var(--light);
            display: flex;
            align-items: stretch;
            overflow: hidden;
        }

        /* ── Panel izquierdo – imagen concesionario ── */
        .side-panel {
            flex: 0 0 52%;
            position: relative;
            overflow: hidden;
            background: var(--navy);
        }

        /* Gradiente oscuro encima */
        .side-panel::before {
            content: '';
            position: absolute; inset: 0; z-index: 1;
            background: linear-gradient(
                135deg,
                rgba(11,31,58,0.72) 0%,
                rgba(26,58,110,0.55) 50%,
                rgba(11,31,58,0.80) 100%
            );
        }

        /* SVG decorativo: líneas de velocidad */
        .side-panel::after {
            content: '';
            position: absolute; inset: 0; z-index: 2;
            background-image:
                repeating-linear-gradient(
                    -30deg,
                    transparent 0px,
                    transparent 60px,
                    rgba(255,255,255,0.03) 60px,
                    rgba(255,255,255,0.03) 61px
                );
        }

        /* Imagen de fondo del concesionario */
        .side-bg {
            position: absolute; inset: 0;
            background:
                url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1200&q=80')
                center center / cover no-repeat;
            filter: saturate(0.6);
            transform: scale(1.04);
            animation: slowZoom 18s ease-in-out infinite alternate;
        }
        @keyframes slowZoom {
            from { transform: scale(1.04); }
            to   { transform: scale(1.10); }
        }

        /* Texto superpuesto */
        .side-content {
            position: absolute; inset: 0; z-index: 3;
            display: flex; flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
        }

        .side-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(29,78,216,0.85);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 4px;
            padding: 0.35rem 0.9rem;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.9);
            margin-bottom: 1rem;
            width: fit-content;
        }

        .side-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
            color: var(--white);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .side-title span { color: #60a5fa; }

        .side-subtitle {
            font-size: 0.92rem;
            color: rgba(255,255,255,0.6);
            font-weight: 300;
            letter-spacing: 0.04em;
            border-left: 2px solid rgba(29,78,216,0.7);
            padding-left: 0.75rem;
        }

        /* ── Panel derecho – formulario ── */
        .form-panel {
            flex: 1;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 3.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Detalle decorativo superior */
        .form-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--navy), var(--accent), var(--silver));
        }

        /* Círculo decorativo de fondo */
        .form-panel::after {
            content: '';
            position: absolute;
            bottom: -120px; right: -120px;
            width: 340px; height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(29,78,216,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Logo */
        .logo-wrap {
            margin-bottom: 2rem;
            animation: fadeDown 0.6s ease both;
        }
        .logo-wrap img { height: 52px; width: auto; }

        /* Encabezado */
        .form-heading {
            margin-bottom: 2rem;
            animation: fadeDown 0.65s ease both;
            animation-delay: 0.05s;
        }

        .form-heading h1 {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.85rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--navy);
            line-height: 1.1;
        }

        .form-heading h1 span { color: var(--accent); }

        .form-heading p {
            margin-top: 0.6rem;
            font-size: 0.875rem;
            color: var(--gray);
            line-height: 1.65;
            font-weight: 300;
        }

        /* Separador */
        .divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin-bottom: 1.75rem;
        }
        .divider span {
            flex: 1; height: 1px;
            background: linear-gradient(90deg, var(--accent), transparent);
        }
        .divider span:last-child {
            background: linear-gradient(270deg, var(--accent), transparent);
        }
        .divider i {
            font-size: 0.65rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--gray);
            font-style: normal;
            white-space: nowrap;
        }

        /* Errores */
        .error-box {
            background: #fef2f2;
            border-left: 3px solid #ef4444;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            color: #dc2626;
        }
        .error-box ul { padding-left: 1rem; }

        /* Campos */
        .field {
            margin-bottom: 1.25rem;
            animation: fadeUp 0.55s ease both;
        }
        .field:nth-child(1) { animation-delay: 0.1s; }
        .field:nth-child(2) { animation-delay: 0.18s; }

        .field label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .field input {
            width: 100%;
            padding: 0.8rem 1rem;
            background: var(--light);
            border: 1.5px solid #dde3ec;
            border-radius: 6px;
            color: var(--navy);
            font-family: 'Lato', sans-serif;
            font-size: 1rem;
            letter-spacing: 0.2em;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field input::placeholder { color: #b0b9c7; letter-spacing: 0.08em; font-size: 0.9rem; }
        .field input:focus {
            border-color: var(--accent);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }

        /* Acciones */
        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.75rem;
            gap: 1rem;
            animation: fadeUp 0.55s ease both;
            animation-delay: 0.25s;
        }

        .btn-link {
            background: none; border: none; cursor: pointer;
            font-family: 'Lato', sans-serif;
            font-size: 0.8rem;
            color: var(--gray);
            text-decoration: underline;
            text-underline-offset: 3px;
            padding: 0;
            transition: color 0.2s;
            flex-shrink: 0;
        }
        .btn-link:hover { color: var(--accent); }

        .btn-submit {
            background: linear-gradient(135deg, var(--navy) 0%, var(--accent) 100%);
            color: white;
            border: none;
            cursor: pointer;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            padding: 0.75rem 2rem;
            border-radius: 6px;
            box-shadow: 0 4px 16px rgba(29,78,216,0.3);
            transition: transform 0.15s, box-shadow 0.15s;
            white-space: nowrap;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(29,78,216,0.4);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Pie */
        .form-footer {
            margin-top: 2.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #edf0f5;
            display: flex; align-items: center; justify-content: space-between;
        }
        .form-footer p {
            font-size: 0.72rem;
            color: #aab3c0;
            letter-spacing: 0.05em;
        }
        .form-footer .dots {
            display: flex; gap: 5px;
        }
        .form-footer .dots span {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--accent);
            opacity: 0.3;
        }
        .form-footer .dots span:first-child { opacity: 1; }
        .form-footer .dots span:nth-child(2) { opacity: 0.55; }

        /* Animaciones */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .side-panel { display: none; }
            .form-panel { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

    {{-- Panel izquierdo decorativo --}}
    <div class="side-panel">
        <div class="side-bg"></div>
        <div class="side-content">
            <div class="side-badge">🔒 Acceso Seguro</div>
            <h2 class="side-title">Tu próximo<br><span>vehículo</span><br>te espera.</h2>
            <p class="side-subtitle">Concesionario oficial Motrix &nbsp;·&nbsp; Bogotá, Colombia</p>
        </div>
    </div>

    {{-- Panel derecho con formulario --}}
    <div class="form-panel" x-data="{ recovery: false }">

        {{-- Logo --}}
        <div class="logo-wrap">
            <img src="data:image/png;base64,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" alt="Motrix">
        </div>

        {{-- Encabezado --}}
        <div class="form-heading">
            <h1>Verificación <span>de acceso</span></h1>
            <p x-show="! recovery">
                Ingresa el código de autenticación proporcionado<br>por tu aplicación verificadora.
            </p>
            <p x-cloak x-show="recovery">
                Ingresa uno de tus códigos de recuperación de emergencia.
            </p>
        </div>

        <div class="divider">
            <span></span>
            <i>Código de seguridad</i>
            <span></span>
        </div>

        {{-- Errores --}}
        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="field" x-show="! recovery">
                <label for="code">Código de verificación</label>
                <input
                    id="code" type="text" inputmode="numeric"
                    name="code" autofocus x-ref="code"
                    autocomplete="one-time-code"
                    placeholder="· · · · · ·"
                />
            </div>

            <div class="field" x-cloak x-show="recovery">
                <label for="recovery_code">Código de recuperación</label>
                <input
                    id="recovery_code" type="text"
                    name="recovery_code" x-ref="recovery_code"
                    autocomplete="one-time-code"
                    placeholder="xxxx-xxxx-xxxx"
                />
            </div>

            <div class="actions">
                <button type="button" class="btn-link"
                    x-show="! recovery"
                    x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                    Usar código de recuperación
                </button>
                <button type="button" class="btn-link"
                    x-cloak x-show="recovery"
                    x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                    Usar código de autenticación
                </button>

                <button type="submit" class="btn-submit">
                    Ingresar →
                </button>
            </div>
        </form>

        <div class="form-footer">
            <p>MOTRIX © {{ date('Y') }} &nbsp;·&nbsp; Concesionario Oficial</p>
            <div class="dots">
                <span></span><span></span><span></span>
            </div>
        </div>

    </div>

</body>
</html>