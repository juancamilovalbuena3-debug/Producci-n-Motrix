<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Configuración ⚙️') }}
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">
        
        <div class="border p-4 rounded bg-white shadow">
            <h3 class="font-bold text-sm text-gray-500 uppercase mb-3">Cambio Rápido de Estilo</h3>
            <div class="flex flex-wrap gap-2">
                <button onclick="guardarPreferenciaRapida('claro')" class="flex items-center gap-2 px-4 py-2 bg-orange-100 text-orange-800 rounded-full hover:bg-orange-200 transition">
                    ☀️ Claro
                </button>
                <button onclick="guardarPreferenciaRapida('oscuro_total')" class="flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-full hover:bg-gray-900 transition">
                    🌙 Oscuro
                </button>
                <button onclick="guardarPreferenciaRapida('profesional')" class="flex items-center gap-2 px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full hover:bg-indigo-200 transition">
                    💼 Profesional
                </button>
            </div>
        </div>

        <div class="border p-4 rounded bg-white shadow">
            <h3 class="font-bold text-lg text-gray-800">Perfil del Usuario</h3>
            <p class="text-gray-600">Actualiza tu nombre, correo y contraseña.</p>
            <button onclick="abrirModalPerfil()" class="mt-2 bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-900">
                Editar Perfil
            </button>
        </div>

        <div class="border p-4 rounded bg-white shadow">
            <h3 class="font-bold text-lg text-gray-800">Preferencias</h3>
            <p class="text-gray-600">Configura el orden de vehículos y notificaciones.</p>
            <button onclick="abrirModalPreferencias()" class="mt-2 bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-900">
                Más Ajustes
            </button>
        </div>

    </div>

    {{-- Modal Editar Perfil --}}
    <div id="modalPerfil" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-gray-800">Editar Perfil</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input id="perfil_nombre" type="text" class="mt-1 block w-full border rounded px-3 py-2 bg-white text-gray-900" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Correo</label>
                    <input id="perfil_correo" type="email" class="mt-1 block w-full border rounded px-3 py-2 bg-white text-gray-900" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nueva Contraseña <span class="text-gray-400">(opcional)</span></label>
                    <input id="perfil_password" type="password" class="mt-1 block w-full border rounded px-3 py-2 bg-white text-gray-900" placeholder="Dejar vacío para no cambiar" />
                </div>
            </div>
            <div id="perfil_msg" class="mt-3 text-sm hidden"></div>
            <div class="flex justify-end gap-2 mt-4">
                <button onclick="cerrarModalPerfil()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                <button onclick="guardarPerfil()" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">Guardar</button>
            </div>
        </div>
    </div>

    {{-- Modal Preferencias --}}
    <div id="modalPreferencias" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-gray-800">Actualizar Preferencias</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tema</label>
                    <select id="pref_tema" class="mt-1 block w-full border rounded px-3 py-2 bg-white text-gray-900">
                        <option value="claro">☀️ Claro</option>
                        <option value="oscuro_total">🌙 Oscuro</option>
                        <option value="profesional">💼 Profesional</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ordenar vehículos por</label>
                    <select id="pref_orden" class="mt-1 block w-full border rounded px-3 py-2 bg-white text-gray-900">
                        <option value="precio_asc">💰 Precio menor primero</option>
                        <option value="precio_desc">💎 Precio mayor primero</option>
                        <option value="nombre">🔤 Nombre</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input id="pref_notificaciones" type="checkbox" class="w-4 h-4" />
                    <label class="text-sm font-medium text-gray-700">Recibir notificaciones</label>
                </div>
            </div>
            <div id="pref_msg" class="mt-3 text-sm hidden"></div>
            <div class="flex justify-end gap-2 mt-4">
                <button onclick="cerrarModalPreferencias()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                <button onclick="guardarPreferencias()" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">Guardar</button>
            </div>
        </div>
    </div>

    <script>
        const API     = 'http://127.0.0.1:8080';
        const USER_ID = {{ auth()->id() }};

        function aplicarTema(tema) {
            const contenedor = document.getElementById('contenedor-principal');
            if (contenedor) {
                contenedor.classList.remove('tema-oscuro', 'tema-profesional');
            }
            document.documentElement.classList.remove('dark');

            if (tema === 'oscuro_total') {
                if (contenedor) contenedor.classList.add('tema-oscuro');
                document.documentElement.classList.add('dark');
            } else if (tema === 'profesional' && contenedor) {
                contenedor.classList.add('tema-profesional');
            }
            localStorage.setItem('tema', tema);
        }

        // Nueva función para cambiar tema con un solo clic
        async function guardarPreferenciaRapida(nuevoTema) {
            aplicarTema(nuevoTema);
            try {
                // Obtenemos el resto de preferencias actuales para no sobreescribirlas con valores vacíos
                const resGet = await fetch(`${API}/configuracion/preferencias?user_id=${USER_ID}`);
                const dataActual = await resGet.json();

                const preferencias = {
                    tema: nuevoTema,
                    orden: dataActual.orden || 'precio_asc',
                    notificaciones: dataActual.notificaciones !== undefined ? dataActual.notificaciones : true,
                };

                await fetch(`${API}/configuracion/preferencias`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: USER_ID, preferencias })
                });
                
                console.log("Tema actualizado: " + nuevoTema);
            } catch(e) {
                console.error("Error al guardar preferencia rápida");
            }
        }

        // ── Perfil ──────────────────────────────────────
        async function abrirModalPerfil() {
            try {
                const res  = await fetch(`${API}/configuracion/perfil?user_id=${USER_ID}`);
                const data = await res.json();
                document.getElementById('perfil_nombre').value   = data.name  || '';
                document.getElementById('perfil_correo').value   = data.email || '';
                document.getElementById('perfil_password').value = '';
                document.getElementById('perfil_msg').classList.add('hidden');
                document.getElementById('modalPerfil').classList.remove('hidden');
            } catch(e) {
                alert('Error al conectar con el microservicio');
            }
        }

        function cerrarModalPerfil() {
            document.getElementById('modalPerfil').classList.add('hidden');
        }

        async function guardarPerfil() {
            const nombre   = document.getElementById('perfil_nombre').value;
            const correo   = document.getElementById('perfil_correo').value;
            const password = document.getElementById('perfil_password').value;
            const body     = { user_id: USER_ID, nombre, correo };
            if (password) body.password = password;

            const res  = await fetch(`${API}/configuracion/perfil`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            });
            const data = await res.json();
            const msg  = document.getElementById('perfil_msg');
            msg.textContent = data.mensaje || data.error;
            msg.className   = res.ok ? 'mt-3 text-sm text-green-600' : 'mt-3 text-sm text-red-600';
            msg.classList.remove('hidden');
        }

        // ── Preferencias ────────────────────────────────
        async function abrirModalPreferencias() {
            try {
                const res  = await fetch(`${API}/configuracion/preferencias?user_id=${USER_ID}`);
                const data = await res.json();
                if (data.tema)  document.getElementById('pref_tema').value  = data.tema;
                if (data.orden) document.getElementById('pref_orden').value = data.orden;
                if (data.notificaciones !== undefined)
                    document.getElementById('pref_notificaciones').checked = data.notificaciones;
                document.getElementById('pref_msg').classList.add('hidden');
                document.getElementById('modalPreferencias').classList.remove('hidden');
            } catch(e) {
                alert('Error al conectar con el microservicio');
            }
        }

        function cerrarModalPreferencias() {
            document.getElementById('modalPreferencias').classList.add('hidden');
        }

        async function guardarPreferencias() {
            const tema  = document.getElementById('pref_tema').value;
            const orden = document.getElementById('pref_orden').value;
            const preferencias = {
                tema,
                orden,
                notificaciones: document.getElementById('pref_notificaciones').checked,
            };

            const res = await fetch(`${API}/configuracion/preferencias`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: USER_ID, preferencias })
            });
            const data = await res.json();

            if (res.ok) {
                localStorage.setItem('orden_vehiculos', orden);
                aplicarTema(tema);
                setTimeout(() => location.reload(), 800);
            } else {
                const msg = document.getElementById('pref_msg');
                msg.textContent = data.error;
                msg.className   = 'mt-3 text-sm text-red-600';
                msg.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>