<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Comprar Vehículo</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 mt-6 space-y-6">

        <div class="bg-white rounded-lg shadow-md p-8 border" style="font-family: 'Times New Roman', serif;">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500"><span id="fecha-hoy"></span></p>
                <h2 class="text-xl font-bold uppercase mt-2">Declaración Jurada de Medio de Pago</h2>
                <p class="text-sm mt-1">Señores: <strong>SUPERINTENDENCIA NACIONAL DE LOS REGISTROS PÚBLICOS</strong></p>
                <p class="text-sm">Registro de Propiedad Vehicular</p>
            </div>
            <p class="text-sm mb-4">
                La empresa <strong>Motrix</strong>, en su calidad de empresa <strong>Vendedora</strong>,
                y el comprador abajo indicado, declaramos la compra del vehículo:
            </p>
            <table class="w-full border border-black text-sm mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-black px-3 py-2 text-left">Vehículo</th>
                        <th class="border border-black px-3 py-2 text-left">Fecha</th>
                        <th class="border border-black px-3 py-2 text-left">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-black px-3 py-2">{{ $vehiculo['nombre'] }}</td>
                        <td class="border border-black px-3 py-2" id="fecha-tabla"></td>
                        <td class="border border-black px-3 py-2">${{ number_format($vehiculo['precio']) }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-sm font-bold uppercase mb-1">Forma de Cancelación:</p>
            <p class="text-sm mb-4">La empresa compradora efectuará la cancelación mediante el siguiente medio de pago indicado abajo.</p>
            <div class="flex gap-3 mt-4">
                <button type="button" onclick="descargarPDF()"
                        class="bg-white hover:bg-gray-100 text-black font-semibold px-6 py-2 rounded-lg shadow-md border border-gray-300 transition-all text-sm">
                    📄 Descargar PDF
                </button>
                <button type="button" onclick="descargarCSV()"
                        class="bg-white hover:bg-gray-100 text-black font-semibold px-6 py-2 rounded-lg shadow-md border border-gray-300 transition-all text-sm">
                    📊 Descargar CSV
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8 border">
            <h3 class="text-lg font-bold mb-6 text-gray-800">📋 Datos de la Compra</h3>

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                    <ul class="list-disc pl-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formCompra" method="POST"
                  action="{{ $tipo === 'moto' ? route('motos.comprar', $vehiculo['id']) : route('carros.comprar', $vehiculo['id']) }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                        <input type="text" name="nombre_comprador" id="inp_nombre" required
                               value="{{ auth()->user()->name }}"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de documento (CC/NIT)</label>
                        <input type="text" name="documento" id="inp_doc" required placeholder="Ej: 1234567890"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Color deseado</label>
                        <select name="color" id="inp_color" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">Seleccione un color</option>
                            <option value="Blanco">⬜ Blanco</option>
                            <option value="Negro">⬛ Negro</option>
                            <option value="Gris">🩶 Gris</option>
                            <option value="Rojo">🟥 Rojo</option>
                            <option value="Azul">🟦 Azul</option>
                            <option value="Plata">🪙 Plata</option>
                            <option value="Verde">🟩 Verde</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Método de pago</label>
                        <select name="metodo_pago" id="metodo_pago" required
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                onchange="mostrarCampos(this.value)">
                            <option value="">Seleccione método</option>
                            <option value="Efectivo">💵 Efectivo</option>
                            <option value="Transferencia">🏦 Transferencia bancaria</option>
                            <option value="Tarjeta">💳 Tarjeta de crédito/débito</option>
                            <option value="Cuotas">📅 A cuotas</option>
                        </select>
                    </div>

                    <div id="campo-banco" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Banco</label>
                        <input type="text" name="banco" id="inp_banco" placeholder="Ej: Bancolombia"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                    <div id="campo-cuotas" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de cuotas</label>
                        <select name="cuotas" id="inp_cuotas" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="6">6 cuotas</option>
                            <option value="12">12 cuotas</option>
                            <option value="24">24 cuotas</option>
                            <option value="36">36 cuotas</option>
                            <option value="48">48 cuotas</option>
                            <option value="60">60 cuotas</option>
                        </select>
                    </div>

                    <div id="campo-tarjeta-numero" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de tarjeta</label>
                        <input type="text" name="tarjeta_numero" id="inp_tarjeta_num"
                               placeholder="1234 5678 9012 3456" maxlength="19"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                               oninput="formatearTarjeta(this)" />
                    </div>

                    <div id="campo-tarjeta-nombre" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre en la tarjeta</label>
                        <input type="text" name="tarjeta_nombre" id="inp_tarjeta_nom"
                               placeholder="Ej: CAMILO PARDO"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                    <div id="campo-tarjeta-venc" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de vencimiento</label>
                        <input type="text" name="tarjeta_vencimiento" id="inp_tarjeta_venc"
                               placeholder="MM/AA" maxlength="5"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                               oninput="formatearVencimiento(this)" />
                    </div>

                    <div id="campo-tarjeta-cvv" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                        <input type="password" name="tarjeta_cvv" id="inp_tarjeta_cvv"
                               placeholder="***" maxlength="4"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono de contacto</label>
                        <input type="tel" name="telefono" id="inp_tel" required placeholder="Ej: 3001234567"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección de entrega</label>
                        <input type="text" name="direccion" id="inp_dir" required placeholder="Ej: Calle 123 # 45-67"
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>

                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones adicionales</label>
                    <textarea name="observaciones" id="inp_obs" rows="3"
                              placeholder="Accesorios adicionales, preferencias especiales..."
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
                    <h4 class="font-bold text-gray-700 mb-2">📄 Resumen</h4>
                    <p class="text-sm text-gray-600">Vehículo: <strong>{{ $vehiculo['nombre'] }}</strong></p>
                    <p class="text-sm text-gray-600">Precio: <strong class="text-green-700">${{ number_format($vehiculo['precio']) }} COP</strong></p>
                    <p class="text-sm text-gray-600">Tipo: <strong>{{ ucfirst($tipo) }}</strong></p>
                </div>

                <div class="mt-6 border rounded-lg p-4 bg-gray-50">
                    <h4 class="font-bold text-gray-700 mb-2">✍️ Firma del Comprador</h4>
                    <p class="text-sm text-gray-500 mb-2">Firme en el recuadro con el mouse o dedo</p>
                    <canvas id="firmaCanvas" width="600" height="150"
                            class="border border-gray-400 rounded bg-white w-full cursor-crosshair"></canvas>
                    <input type="hidden" name="firma_comprador" id="firma_comprador" />
                    <div class="mt-2">
                        <button type="button" onclick="limpiarFirma()"
                                class="bg-white hover:bg-gray-100 text-black border border-gray-300 px-4 py-1 rounded text-sm shadow">
                            🗑️ Limpiar firma
                        </button>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-6 text-center text-sm text-gray-600 border-t pt-4">
                    <div>
                        <div class="border-b border-black mb-1 h-8"></div>
                        <p><strong>CONCESIONARIO</strong></p>
                        <p>Motrix S.A.S.</p>
                    </div>
                    <div>
                        <div class="border-b border-black mb-1 h-8"></div>
                        <p><strong>COMPRADOR</strong></p>
                        <p>Firma y Huella</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="button" onclick="confirmarCompra()"
                            class="bg-white hover:bg-gray-100 text-black font-semibold px-8 py-3 rounded-lg shadow-md border border-gray-300 transition-all">
                        ✅ Confirmar Compra
                    </button>
                    <a href="{{ url()->previous() }}"
                       class="bg-white hover:bg-gray-100 text-black font-semibold px-8 py-3 rounded-lg shadow-md border border-gray-300 transition-all">
                        ❌ Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const hoy = new Date().toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('fecha-hoy').textContent = hoy;
        document.getElementById('fecha-tabla').textContent = hoy;

        function mostrarCampos(valor) {
            document.getElementById('campo-banco').classList.toggle('hidden', valor !== 'Transferencia');
            document.getElementById('campo-cuotas').classList.toggle('hidden', valor !== 'Cuotas');
            const esTarjeta = valor === 'Tarjeta';
            document.getElementById('campo-tarjeta-numero').classList.toggle('hidden', !esTarjeta);
            document.getElementById('campo-tarjeta-nombre').classList.toggle('hidden', !esTarjeta);
            document.getElementById('campo-tarjeta-venc').classList.toggle('hidden',  !esTarjeta);
            document.getElementById('campo-tarjeta-cvv').classList.toggle('hidden',   !esTarjeta);
        }

        function formatearTarjeta(input) {
            let val = input.value.replace(/\D/g, '').substring(0, 16);
            input.value = val.replace(/(.{4})/g, '$1 ').trim();
        }

        function formatearVencimiento(input) {
            let val = input.value.replace(/\D/g, '').substring(0, 4);
            if (val.length >= 3) val = val.substring(0,2) + '/' + val.substring(2);
            input.value = val;
        }

        function getDatos() {
            return {
                vehiculo:  '{{ $vehiculo['nombre'] }}',
                precio:    '${{ number_format($vehiculo['precio']) }} COP',
                tipo:      '{{ ucfirst($tipo) }}',
                fecha:     hoy,
                nombre:    document.getElementById('inp_nombre')?.value || '',
                documento: document.getElementById('inp_doc')?.value    || '',
                color:     document.getElementById('inp_color')?.value  || '',
                metodo:    document.getElementById('metodo_pago')?.value || '',
                telefono:  document.getElementById('inp_tel')?.value    || '',
                direccion: document.getElementById('inp_dir')?.value    || '',
                obs:       document.getElementById('inp_obs')?.value    || '',
            };
        }

        function descargarPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const d = getDatos();
            doc.setFontSize(14); doc.setFont('times', 'bold');
            doc.text('DECLARACIÓN JURADA DE MEDIO DE PAGO', 105, 20, { align: 'center' });
            doc.setFontSize(10); doc.setFont('times', 'normal');
            doc.text('Señores: SUPERINTENDENCIA NACIONAL DE LOS REGISTROS PÚBLICOS', 105, 28, { align: 'center' });
            doc.text('Registro de Propiedad Vehicular', 105, 34, { align: 'center' });
            doc.text(`Fecha: ${d.fecha}`, 14, 44);
            doc.setFont('times', 'bold'); doc.text('Datos del Vehículo:', 14, 54);
            doc.setFont('times', 'normal');
            doc.text(`Vehículo: ${d.vehiculo}`, 14, 62);
            doc.text(`Precio: ${d.precio}`, 14, 70);
            doc.text(`Tipo: ${d.tipo}`, 14, 78);
            doc.setFont('times', 'bold'); doc.text('Datos del Comprador:', 14, 90);
            doc.setFont('times', 'normal');
            doc.text(`Nombre: ${d.nombre}`, 14, 98);
            doc.text(`Documento: ${d.documento}`, 14, 106);
            doc.text(`Teléfono: ${d.telefono}`, 14, 114);
            doc.text(`Dirección: ${d.direccion}`, 14, 122);
            doc.text(`Color deseado: ${d.color}`, 14, 130);
            doc.text(`Método de pago: ${d.metodo}`, 14, 138);
            if (d.obs) {
                doc.setFont('times', 'bold'); doc.text('Observaciones:', 14, 150);
                doc.setFont('times', 'normal');
                doc.text(doc.splitTextToSize(d.obs, 180), 14, 158);
            }
            const firmaData = document.getElementById('firma_comprador').value;
            if (firmaData) doc.addImage(firmaData, 'PNG', 120, 200, 60, 20);
            doc.line(14, 220, 90, 220); doc.line(120, 220, 196, 220);
            doc.text('CONCESIONARIO - Motrix S.A.S.', 14, 226);
            doc.text('COMPRADOR - Firma y Huella', 120, 226);
            doc.save(`compra_${d.vehiculo.replace(/ /g,'_')}.pdf`);
        }

        function descargarCSV() {
            const d = getDatos();
            const rows = [
                ['Campo','Valor'],['Fecha',d.fecha],['Vehículo',d.vehiculo],
                ['Precio',d.precio],['Tipo',d.tipo],['Nombre comprador',d.nombre],
                ['Documento',d.documento],['Color deseado',d.color],
                ['Método de pago',d.metodo],['Teléfono',d.telefono],
                ['Dirección',d.direccion],['Observaciones',d.obs],
            ];
            const csv  = rows.map(r => r.map(c => `"${c}"`).join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url  = URL.createObjectURL(blob);
            const a    = document.createElement('a');
            a.href = url; a.download = `compra_${d.vehiculo.replace(/ /g,'_')}.csv`;
            a.click(); URL.revokeObjectURL(url);
        }

        const canvas = document.getElementById('firmaCanvas');
        const ctx    = canvas.getContext('2d');
        let firmando = false;

        canvas.addEventListener('mousedown', e => { firmando = true; ctx.beginPath(); ctx.moveTo(e.offsetX, e.offsetY); });
        canvas.addEventListener('mousemove', e => {
            if (!firmando) return;
            ctx.lineWidth = 2; ctx.lineCap = 'round'; ctx.strokeStyle = '#000';
            ctx.lineTo(e.offsetX, e.offsetY); ctx.stroke();
        });
        canvas.addEventListener('mouseup',    () => { firmando = false; guardarFirma(); });
        canvas.addEventListener('mouseleave', () => { firmando = false; });
        canvas.addEventListener('touchstart', e => { e.preventDefault(); firmando = true; const t = e.touches[0]; const r = canvas.getBoundingClientRect(); ctx.beginPath(); ctx.moveTo(t.clientX-r.left, t.clientY-r.top); });
        canvas.addEventListener('touchmove',  e => { e.preventDefault(); if (!firmando) return; const t = e.touches[0]; const r = canvas.getBoundingClientRect(); ctx.lineWidth=2; ctx.lineCap='round'; ctx.strokeStyle='#000'; ctx.lineTo(t.clientX-r.left, t.clientY-r.top); ctx.stroke(); });
        canvas.addEventListener('touchend',   () => { firmando = false; guardarFirma(); });

        function guardarFirma() {
            document.getElementById('firma_comprador').value = canvas.toDataURL('image/png');
        }
        function limpiarFirma() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('firma_comprador').value = '';
        }
        function confirmarCompra() {
            document.getElementById('firma_comprador').value = canvas.toDataURL('image/png');
            document.getElementById('formCompra').submit();
        }
    </script>

</x-app-layout>
