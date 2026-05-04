<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 tracking-tight">Comprar Vehículo</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 mt-6 space-y-8">

        <!-- Sección Declaración Jurada -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 transition-all hover:shadow-xl" style="font-family: 'Times New Roman', serif;">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500"><span id="fecha-hoy"></span></p>
                <h2 class="text-xl font-bold uppercase mt-2 text-gray-900">Declaración Jurada de Medio de Pago</h2>
                <p class="text-sm mt-1 text-gray-700">Señores: <strong>SUPERINTENDENCIA NACIONAL DE LOS REGISTROS PÚBLICOS</strong></p>
                <p class="text-sm text-gray-700">Registro de Propiedad Vehicular</p>
            </div>
            <p class="text-sm mb-4 text-gray-800">
                La empresa <strong>Motrix</strong>, en su calidad de empresa <strong>Vendedora</strong>,
                y el comprador abajo indicado, declaramos la compra del vehículo:
            </p>
            <div class="overflow-hidden rounded-lg border border-black mb-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b border-black">
                            <th class="border-r border-black px-4 py-3 text-left">Vehículo</th>
                            <th class="border-r border-black px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-r border-black px-4 py-3 font-medium">{{ $vehiculo['nombre'] }}</td>
                            <td class="border-r border-black px-4 py-3" id="fecha-tabla"></td>
                            <td class="px-4 py-3 font-bold">${{ number_format($vehiculo['precio']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="text-sm font-bold uppercase mb-1 text-gray-900">Forma de Cancelación:</p>
            <p class="text-sm mb-6 text-gray-800">La empresa compradora efectuará la cancelación mediante el siguiente medio de pago indicado abajo.</p>
            
            <div class="flex flex-wrap gap-4 mt-4">
                <button type="button" onclick="descargarPDF()"
                        class="bg-white hover:bg-gray-50 text-gray-800 font-semibold px-6 py-2.5 rounded-lg shadow-sm border border-gray-300 transition-all text-sm flex items-center gap-2 hover:shadow-md">
                    📄 Descargar PDF
                </button>
                <button type="button" onclick="descargarCSV()"
                        class="bg-white hover:bg-gray-50 text-gray-800 font-semibold px-6 py-2.5 rounded-lg shadow-sm border border-gray-300 transition-all text-sm flex items-center gap-2 hover:shadow-md">
                    📊 Descargar CSV
                </button>
            </div>
        </div>

        <!-- Formulario de Compra -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
            <h3 class="text-xl font-bold mb-6 text-gray-800 border-b pb-3">📋 Datos de la Compra</h3>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm shadow-sm">
                    <ul class="list-disc pl-4 space-y-1">
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
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo</label>
                        <input type="text" name="nombre_comprador" id="inp_nombre" required
                               value="{{ auth()->user()->name }}"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Número de documento (CC/NIT)</label>
                        <input type="text" name="documento" id="inp_doc" required placeholder="Ej: 1234567890"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" />
                    </div>

                    <!-- Selector Visual de Color -->
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Color deseado</label>
                        <div class="flex flex-wrap gap-3 mb-2">
                            <button type="button" onclick="seleccionarColor('Blanco', this)" class="color-swatch w-8 h-8 rounded-full border border-gray-300 shadow-sm bg-white transition-all hover:scale-110 focus:outline-none" title="Blanco"></button>
                            <button type="button" onclick="seleccionarColor('Negro', this)" class="color-swatch w-8 h-8 rounded-full border border-gray-400 shadow-sm bg-black transition-all hover:scale-110 focus:outline-none" title="Negro"></button>
                            <button type="button" onclick="seleccionarColor('Gris', this)" class="color-swatch w-8 h-8 rounded-full border border-gray-400 shadow-sm bg-gray-400 transition-all hover:scale-110 focus:outline-none" title="Gris"></button>
                            <button type="button" onclick="seleccionarColor('Rojo', this)" class="color-swatch w-8 h-8 rounded-full border border-gray-400 shadow-sm bg-red-600 transition-all hover:scale-110 focus:outline-none" title="Rojo"></button>
                            <button type="button" onclick="seleccionarColor('Azul', this)" class="color-swatch w-8 h-8 rounded-full border border-gray-400 shadow-sm bg-blue-600 transition-all hover:scale-110 focus:outline-none" title="Azul"></button>
                            <button type="button" onclick="seleccionarColor('Plata', this)" class="color-swatch w-8 h-8 rounded-full border border-gray-400 shadow-sm bg-slate-300 transition-all hover:scale-110 focus:outline-none" title="Plata"></button>
                            <button type="button" onclick="seleccionarColor('Verde', this)" class="color-swatch w-8 h-8 rounded-full border border-gray-400 shadow-sm bg-green-600 transition-all hover:scale-110 focus:outline-none" title="Verde"></button>
                        </div>
                        <select name="color" id="inp_color" required class="w-full border border-gray-300 bg-white rounded-lg px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm shadow-sm transition-colors pointer-events-none text-gray-600">
                            <option value="">Seleccione un color (usa los círculos arriba)</option>
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
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Método de pago</label>
                        <select name="metodo_pago" id="metodo_pago" required
                                class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                                onchange="mostrarCampos(this.value)">
                            <option value="">Seleccione método</option>
                            <option value="Efectivo">💵 Efectivo</option>
                            <option value="Transferencia">🏦 Transferencia bancaria</option>
                            <option value="Tarjeta">💳 Tarjeta de crédito/débito</option>
                            <option value="Cuotas">📅 A cuotas</option>
                        </select>
                    </div>

                    <!-- Campos dinámicos de pago -->
                    <div id="campo-banco" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Banco</label>
                        <input type="text" name="banco" id="inp_banco" placeholder="Ej: Bancolombia"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" />
                    </div>

                    <div id="campo-cuotas" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Número de cuotas</label>
                        <select name="cuotas" id="inp_cuotas" class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">
                            <option value="6">6 cuotas</option>
                            <option value="12">12 cuotas</option>
                            <option value="24">24 cuotas</option>
                            <option value="36">36 cuotas</option>
                            <option value="48">48 cuotas</option>
                            <option value="60">60 cuotas</option>
                        </select>
                    </div>

                    <div id="campo-tarjeta-numero" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Número de tarjeta</label>
                        <input type="text" name="tarjeta_numero" id="inp_tarjeta_num"
                               placeholder="1234 5678 9012 3456" maxlength="19"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm font-mono"
                               oninput="formatearTarjeta(this)" />
                    </div>

                    <div id="campo-tarjeta-nombre" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre en la tarjeta</label>
                        <input type="text" name="tarjeta_nombre" id="inp_tarjeta_nom"
                               placeholder="Ej: CAMILO VALBUENA"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm uppercase" />
                    </div>

                    <div id="campo-tarjeta-venc" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de vencimiento</label>
                        <input type="text" name="tarjeta_vencimiento" id="inp_tarjeta_venc"
                               placeholder="MM/AA" maxlength="5"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm text-center"
                               oninput="formatearVencimiento(this)" />
                    </div>

                    <div id="campo-tarjeta-cvv" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">CVV</label>
                        <input type="password" name="tarjeta_cvv" id="inp_tarjeta_cvv"
                               placeholder="***" maxlength="4"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm text-center" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono de contacto</label>
                        <input type="tel" name="telefono" id="inp_tel" required placeholder="Ej: 3001234567"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Dirección de entrega</label>
                        <input type="text" name="direccion" id="inp_dir" required placeholder="Ej: Calle 123 # 45-67"
                               class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm" />
                    </div>

                </div>

                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones adicionales</label>
                    <textarea name="observaciones" id="inp_obs" rows="3"
                              placeholder="Accesorios adicionales, preferencias especiales..."
                              class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-2.5 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"></textarea>
                </div>

                <!-- Resumen -->
                <div class="mt-8 p-5 bg-blue-50/50 rounded-xl border border-blue-100 shadow-sm">
                    <h4 class="font-bold text-blue-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Resumen de la Orden
                    </h4>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <p class="text-gray-600">Vehículo:</p> <p class="font-semibold text-gray-900 text-right">{{ $vehiculo['nombre'] }}</p>
                        <p class="text-gray-600">Tipo:</p> <p class="font-semibold text-gray-900 text-right">{{ ucfirst($tipo) }}</p>
                        <p class="text-gray-600">Total a pagar:</p> <p class="font-bold text-green-700 text-right text-lg">${{ number_format($vehiculo['precio']) }} COP</p>
                    </div>
                </div>

                <!-- Firma -->
                <div class="mt-8 border border-gray-200 rounded-xl p-5 bg-gray-50 shadow-sm">
                    <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        ✍️ Firma del Comprador
                    </h4>
                    <p class="text-sm text-gray-500 mb-3">Firme en el recuadro inferior con el mouse o su dedo.</p>
                    <div class="bg-white p-1 border border-gray-300 rounded-lg shadow-inner">
                        <canvas id="firmaCanvas" width="600" height="150"
                                class="w-full cursor-crosshair rounded"></canvas>
                    </div>
                    <input type="hidden" name="firma_comprador" id="firma_comprador" />
                    <div class="mt-3 flex justify-end">
                        <button type="button" onclick="limpiarFirma()"
                                class="bg-white hover:bg-gray-100 text-gray-700 font-medium border border-gray-300 px-4 py-1.5 rounded-lg text-sm shadow-sm transition-colors flex items-center gap-1">
                            🗑️ Limpiar firma
                        </button>
                    </div>
                </div>

                <!-- Firma Centrada -->
                <div class="mt-8 flex justify-center text-center text-sm text-gray-600 border-t border-gray-200 pt-6">
                    <div class="w-64">
                        <div class="border-b-2 border-gray-800 mb-2 h-8 mx-4"></div>
                        <p class="font-bold text-gray-900">CONCESIONARIO</p>
                        <p>Motrix S.A.S.</p>
                    </div>
                </div>

                <div class="mt-10 flex flex-wrap gap-4 justify-center md:justify-start">
                    <button type="button" onclick="intentarConfirmar()"
                            class="bg-black hover:bg-gray-800 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg transition-transform hover:scale-105 flex items-center gap-2">
                        ✅ Confirmar Compra
                    </button>
                    <a href="{{ url()->previous() }}"
                       class="bg-white hover:bg-gray-50 text-gray-700 font-semibold px-8 py-3.5 rounded-xl shadow-md border border-gray-300 transition-colors flex items-center gap-2">
                        ❌ Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div id="modalConfirmacion" class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div id="modalContenido" class="bg-white p-8 rounded-2xl shadow-2xl max-w-sm w-full mx-4 text-center transform transition-transform duration-300 scale-95">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">¿Confirmar compra?</h3>
            <p class="text-sm text-gray-600 mb-6">Estás a punto de registrar la compra de <strong>{{ $vehiculo['nombre'] }}</strong> por un total de <strong>${{ number_format($vehiculo['precio']) }} COP</strong>.</p>
            <div class="flex flex-col gap-3">
                <button type="button" onclick="ejecutarCompra()" class="w-full px-4 py-3 bg-black text-white hover:bg-gray-800 rounded-xl font-bold shadow-md transition-all hover:shadow-lg">
                    Sí, realizar compra
                </button>
                <button type="button" onclick="cerrarModal()" class="w-full px-4 py-3 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-semibold transition-colors">
                    Revisar de nuevo
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const hoy = new Date().toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('fecha-hoy').textContent = hoy;
        document.getElementById('fecha-tabla').textContent = hoy;

        // Lógica de Swatches de Color
        function seleccionarColor(color, btnElement) {
            // Actualizar select oculto
            document.getElementById('inp_color').value = color;
            
            // Efecto visual en los botones
            const swatches = document.querySelectorAll('.color-swatch');
            swatches.forEach(el => el.classList.remove('ring-4', 'ring-blue-400', 'scale-110'));
            
            btnElement.classList.add('ring-4', 'ring-blue-400', 'scale-110');
        }

        // Lógica Modal de Confirmación
        function intentarConfirmar() {
            const form = document.getElementById('formCompra');
            
            // Validar HTML5 nativo antes de mostrar el modal
            if (form.reportValidity()) {
                // Guardar firma temporalmente
                document.getElementById('firma_comprador').value = canvas.toDataURL('image/png');
                
                // Mostrar Modal
                const modal = document.getElementById('modalConfirmacion');
                const contenido = document.getElementById('modalContenido');
                
                modal.classList.remove('hidden');
                // Timeout para permitir la transición de opacidad y escala
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.classList.add('opacity-100');
                    contenido.classList.remove('scale-95');
                    contenido.classList.add('scale-100');
                }, 10);
            }
        }

        function cerrarModal() {
            const modal = document.getElementById('modalConfirmacion');
            const contenido = document.getElementById('modalContenido');
            
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            contenido.classList.remove('scale-100');
            contenido.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function ejecutarCompra() {
            // Asegurar que la firma esté actualizada antes de enviar
            document.getElementById('firma_comprador').value = canvas.toDataURL('image/png');
            document.getElementById('formCompra').submit();
        }

        // Lógica existente de campos dinámicos
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

        // Lógica existente de PDF/CSV
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

        // Lógica existente de Firma
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
    </script>

</x-app-layout>