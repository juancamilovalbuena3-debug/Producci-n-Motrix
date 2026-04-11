from aiohttp import web
import json
import aiomysql
import re
from datetime import datetime

carros = {
    1: {"id": 1, "nombre": "Toyota Corolla 2023", "precio": 85000000, "transmision": "Automatico", "combustible": "Gasolina", "imagen": "images/carros/Toyota Corolla 2023.jpg", "anio": 2023, "kilometraje": 0, "colores": ["Blanco", "Negro", "Gris", "Rojo"], "garantia": "3 años / 100,000 km", "seguridad": "ABS, Airbags x6, Control de estabilidad, Cámara trasera", "descripcion": "Sedán compacto ideal para ciudad y carretera, con excelente rendimiento de combustible y tecnología de punta."},
    2: {"id": 2, "nombre": "Mazda CX-5 2022", "precio": 120000000, "transmision": "Automatico", "combustible": "Diesel", "imagen": "images/carros/Mazda.jpg", "anio": 2022, "kilometraje": 15000, "colores": ["Rojo", "Blanco", "Gris", "Azul"], "garantia": "3 años / 100,000 km", "seguridad": "ABS, Airbags x6, Control de tracción, Asistente de frenado, Alerta de punto ciego", "descripcion": "SUV compacto con diseño deportivo y equipamiento de lujo, perfecto para todo terreno."},
    3: {"id": 3, "nombre": "Ford EcoSport 2022", "precio": 95000000, "transmision": "Automatico", "combustible": "Gasolina", "imagen": "images/carros/Ford.jpg", "anio": 2022, "kilometraje": 20000, "colores": ["Azul", "Negro", "Plata", "Blanco"], "garantia": "3 años / 60,000 km", "seguridad": "ABS, Airbags x4, Control de estabilidad, Sensor de estacionamiento", "descripcion": "SUV urbano ágil y versátil, con gran capacidad de maletero y conectividad total."},
    4: {"id": 4, "nombre": "Hyundai Tucson 2023", "precio": 130000000, "transmision": "Automatico", "combustible": "Diesel", "imagen": "images/carros/Hyundai.jpg", "anio": 2023, "kilometraje": 0, "colores": ["Blanco", "Gris", "Negro", "Verde"], "garantia": "5 años / 100,000 km", "seguridad": "ABS, Airbags x8, Control de crucero adaptativo, Alerta de colisión frontal, Lane assist", "descripcion": "SUV mediano con diseño premium y tecnología híbrida disponible, ideal para familias."},
    5: {"id": 5, "nombre": "Volkswagen Golf 2021", "precio": 88000000, "transmision": "Automatico", "combustible": "Gasolina", "imagen": "images/carros/golf.jpg", "anio": 2021, "kilometraje": 30000, "colores": ["Blanco", "Rojo", "Gris", "Azul"], "garantia": "2 años / 60,000 km", "seguridad": "ABS, Airbags x6, Control de estabilidad, Asistente de frenado de emergencia", "descripcion": "Hatchback icónico alemán con manejo preciso, bajo consumo y tecnología avanzada."},
}

motos = {
    1: {"id": 1, "nombre": "Yamaha MT-07 2022", "precio": 32000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/Yamaha MT-07 2022.jpg", "anio": 2022, "kilometraje": 5000, "colores": ["Negro", "Gris", "Azul"], "garantia": "2 años / 30,000 km", "seguridad": "ABS, Control de tracción, Modos de conducción", "descripcion": "Naked sport de alto rendimiento con motor bicilíndrico de 689cc, ágil y potente para ciudad y carretera."},
    2: {"id": 2, "nombre": "Honda CBR500R", "precio": 28000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/honda-cbr500r.jpg", "anio": 2022, "kilometraje": 8000, "colores": ["Rojo", "Negro", "Blanco"], "garantia": "2 años / 30,000 km", "seguridad": "ABS, Asistente de arranque en pendiente", "descripcion": "Sport media con carenado aerodinámico, ideal para iniciarse en el mundo de las motos deportivas."},
    3: {"id": 3, "nombre": "Kawasaki Ninja 650 2023", "precio": 35000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/Kawasaki Ninja 650 2023.jpg", "anio": 2023, "kilometraje": 0, "colores": ["Verde", "Negro", "Gris"], "garantia": "2 años / 30,000 km", "seguridad": "ABS, Control de tracción, Modos de conducción Sport/Road", "descripcion": "Sport touring versátil con motor paralelo de 649cc, cómoda para viajes largos y dinámica en ciudad."},
    4: {"id": 4, "nombre": "KTM Duke 390 2023", "precio": 22000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/KTM Duke 390 2023.jpg", "anio": 2023, "kilometraje": 0, "colores": ["Naranja", "Negro", "Blanco"], "garantia": "2 años / 30,000 km", "seguridad": "ABS cornering, Control de tracción, Quickshifter", "descripcion": "Naked urbana con carácter agresivo, motor monocilíndrico de 373cc y tecnología de superbike."},
    5: {"id": 5, "nombre": "BMW G310R 2022", "precio": 25000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/BMW G310R 2022.jpg", "anio": 2022, "kilometraje": 10000, "colores": ["Blanco", "Negro", "Azul"], "garantia": "2 años / 30,000 km", "seguridad": "ABS, Asistente de arranque en pendiente, Iluminación LED", "descripcion": "Naked premium de acceso con calidad BMW, motor de 313cc ideal para ciudad y viajes de fin de semana."},
}

@web.middleware
async def cors_middleware(request, handler):
    if request.method == 'OPTIONS':
        return web.Response(headers={
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers': 'Content-Type'
        })
    response = await handler(request)
    response.headers['Access-Control-Allow-Origin'] = '*'
    return response

# ── DB Pool ────────────────────────────────────────────
async def get_pool(app):
    app['db'] = await aiomysql.create_pool(
        host='127.0.0.1', port=3306,
        user='root', password='', db='hr', autocommit=True
    )
    # Crear tabla si no existe
    async with app['db'].acquire() as conn:
        async with conn.cursor() as cur:
            await cur.execute("""
                CREATE TABLE IF NOT EXISTS compras_python (
                    id         INT AUTO_INCREMENT PRIMARY KEY,
                    vehiculo   VARCHAR(255) NOT NULL,
                    precio     BIGINT       NOT NULL,
                    tipo       ENUM('carro','moto') NOT NULL,
                    fecha      DATETIME     NOT NULL,
                    mes        VARCHAR(7)   NOT NULL,
                    mes_nombre VARCHAR(50)  NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            """)

async def close_pool(app):
    app['db'].close()
    await app['db'].wait_closed()

# ── Carros ─────────────────────────────────────────────
async def get_productos(request):
    return web.Response(text=json.dumps(list(carros.values()), ensure_ascii=False), content_type='application/json')

async def get_producto(request):
    carro_id = int(request.match_info['id'])
    carro = carros.get(carro_id)
    if not carro:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)
    return web.Response(text=json.dumps(carro, ensure_ascii=False), content_type='application/json')

# ── CORREGIDO: guarda en MySQL en vez de lista en memoria ──
async def comprar_producto(request):
    carro_id = int(request.match_info['id'])
    carro = carros.get(carro_id)
    if not carro:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)

    ahora = datetime.now()
    async with request.app['db'].acquire() as conn:
        async with conn.cursor(aiomysql.DictCursor) as cur:
            await cur.execute(
                """INSERT INTO compras_python (vehiculo, precio, tipo, fecha, mes, mes_nombre)
                   VALUES (%s, %s, %s, %s, %s, %s)""",
                (
                    carro['nombre'],
                    carro['precio'],
                    'carro',
                    ahora.strftime("%Y-%m-%d %H:%M:%S"),
                    ahora.strftime("%Y-%m"),
                    ahora.strftime("%B %Y"),
                )
            )
            compra_id = cur.lastrowid

    return web.Response(text=json.dumps({
        "id_compra":  compra_id,
        "vehiculo":   carro['nombre'],
        "precio":     carro['precio'],
        "tipo":       "carro",
        "estado":     "Compra exitosa",
        "fecha":      ahora.strftime("%Y-%m-%d %H:%M:%S"),
    }, ensure_ascii=False), content_type='application/json')

# ── Motos ──────────────────────────────────────────────
async def get_motos(request):
    return web.Response(text=json.dumps(list(motos.values()), ensure_ascii=False), content_type='application/json')

async def get_moto(request):
    moto_id = int(request.match_info['id'])
    moto = motos.get(moto_id)
    if not moto:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)
    return web.Response(text=json.dumps(moto, ensure_ascii=False), content_type='application/json')

# ── CORREGIDO: guarda en MySQL en vez de lista en memoria ──
async def comprar_moto(request):
    moto_id = int(request.match_info['id'])
    moto = motos.get(moto_id)
    if not moto:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)

    ahora = datetime.now()
    async with request.app['db'].acquire() as conn:
        async with conn.cursor(aiomysql.DictCursor) as cur:
            await cur.execute(
                """INSERT INTO compras_python (vehiculo, precio, tipo, fecha, mes, mes_nombre)
                   VALUES (%s, %s, %s, %s, %s, %s)""",
                (
                    moto['nombre'],
                    moto['precio'],
                    'moto',
                    ahora.strftime("%Y-%m-%d %H:%M:%S"),
                    ahora.strftime("%Y-%m"),
                    ahora.strftime("%B %Y"),
                )
            )
            compra_id = cur.lastrowid

    return web.Response(text=json.dumps({
        "id_compra":  compra_id,
        "vehiculo":   moto['nombre'],
        "precio":     moto['precio'],
        "tipo":       "moto",
        "estado":     "Compra exitosa",
        "fecha":      ahora.strftime("%Y-%m-%d %H:%M:%S"),
    }, ensure_ascii=False), content_type='application/json')

# ── CORREGIDO: lee desde MySQL, persiste tras reinicio ──
async def get_reporte(request):
    async with request.app['db'].acquire() as conn:
        async with conn.cursor(aiomysql.DictCursor) as cur:
            await cur.execute("SELECT * FROM compras_python ORDER BY fecha DESC")
            compras = await cur.fetchall()

    # Convertir datetime de MySQL a string
    listado = []
    for c in compras:
        listado.append({
            "id_compra":  c['id'],
            "vehiculo":   c['vehiculo'],
            "precio":     c['precio'],
            "tipo":       c['tipo'],
            "fecha":      c['fecha'].strftime("%Y-%m-%d %H:%M:%S") if hasattr(c['fecha'], 'strftime') else str(c['fecha']),
            "mes":        c['mes'],
            "mes_nombre": c['mes_nombre'],
            "estado":     "Compra exitosa",
        })

    total_dinero = sum(c['precio'] for c in listado)
    total_carros = [c for c in listado if c['tipo'] == 'carro']
    total_motos  = [c for c in listado if c['tipo'] == 'moto']

    ventas_por_mes = {}
    for c in listado:
        mes = c['mes_nombre']
        if mes not in ventas_por_mes:
            ventas_por_mes[mes] = {"mes": mes, "cantidad": 0, "total": 0}
        ventas_por_mes[mes]['cantidad'] += 1
        ventas_por_mes[mes]['total']    += c['precio']

    conteo = {}
    for c in listado:
        conteo[c['vehiculo']] = conteo.get(c['vehiculo'], 0) + 1
    mas_vendido = max(conteo, key=conteo.get) if conteo else None

    ventas_por_vehiculo_carros = {}
    for c in total_carros:
        ventas_por_vehiculo_carros[c['vehiculo']] = ventas_por_vehiculo_carros.get(c['vehiculo'], 0) + 1

    ventas_por_vehiculo_motos = {}
    for c in total_motos:
        ventas_por_vehiculo_motos[c['vehiculo']] = ventas_por_vehiculo_motos.get(c['vehiculo'], 0) + 1

    reporte = {
        "total_ventas":               len(listado),
        "total_dinero":               total_dinero,
        "total_carros":               len(total_carros),
        "total_motos":                len(total_motos),
        "mas_vendido":                mas_vendido,
        "ventas_por_mes":             list(ventas_por_mes.values()),
        "ventas_por_vehiculo_carros": ventas_por_vehiculo_carros,
        "ventas_por_vehiculo_motos":  ventas_por_vehiculo_motos,
        "listado":                    listado,
    }
    return web.Response(text=json.dumps(reporte, ensure_ascii=False), content_type='application/json')

# ── NUEVO: eliminar compra (llamado desde Laravel) ──────
async def eliminar_compra(request):
    compra_id = int(request.match_info['id'])
    async with request.app['db'].acquire() as conn:
        async with conn.cursor() as cur:
            await cur.execute("DELETE FROM compras_python WHERE id = %s", (compra_id,))
            affected = cur.rowcount
    if affected == 0:
        return web.Response(text=json.dumps({"error": "Compra no encontrada"}), content_type='application/json', status=404)
    return web.Response(text=json.dumps({"mensaje": "Compra eliminada correctamente"}), content_type='application/json')

# ── Configuración ──────────────────────────────────────
async def get_perfil(request):
    user_id = request.rel_url.query.get('user_id', 1)
    async with request.app['db'].acquire() as conn:
        async with conn.cursor(aiomysql.DictCursor) as cur:
            await cur.execute("SELECT id, name, email FROM users WHERE id = %s", (user_id,))
            user = await cur.fetchone()
    if not user:
        return web.Response(text=json.dumps({"error": "Usuario no encontrado"}), content_type='application/json', status=404)
    return web.Response(text=json.dumps(user, ensure_ascii=False), content_type='application/json')

async def editar_perfil(request):
    data = await request.json()
    user_id  = data.get('user_id', 1)
    name     = data.get('nombre')
    email    = data.get('correo')
    password = data.get('password')
    if not name or not email:
        return web.Response(text=json.dumps({"error": "nombre y correo son requeridos"}), content_type='application/json', status=400)
    async with request.app['db'].acquire() as conn:
        async with conn.cursor() as cur:
            if password:
                await cur.execute("UPDATE users SET name=%s, email=%s, password=%s WHERE id=%s", (name, email, password, user_id))
            else:
                await cur.execute("UPDATE users SET name=%s, email=%s WHERE id=%s", (name, email, user_id))
    return web.Response(text=json.dumps({"mensaje": "Perfil actualizado correctamente"}), content_type='application/json')

async def get_preferencias(request):
    user_id = request.rel_url.query.get('user_id', 1)
    async with request.app['db'].acquire() as conn:
        async with conn.cursor(aiomysql.DictCursor) as cur:
            await cur.execute("SELECT preferencias FROM users WHERE id = %s", (user_id,))
            row = await cur.fetchone()
    if not row:
        return web.Response(text=json.dumps({"error": "Usuario no encontrado"}), content_type='application/json', status=404)
    prefs = json.loads(row['preferencias']) if row['preferencias'] else {}
    return web.Response(text=json.dumps(prefs, ensure_ascii=False), content_type='application/json')

async def actualizar_preferencias(request):
    data = await request.json()
    user_id      = data.get('user_id', 1)
    preferencias = data.get('preferencias')
    if not preferencias:
        return web.Response(text=json.dumps({"error": "preferencias es requerido"}), content_type='application/json', status=400)
    async with request.app['db'].acquire() as conn:
        async with conn.cursor() as cur:
            await cur.execute("UPDATE users SET preferencias=%s WHERE id=%s", (json.dumps(preferencias), user_id))
    return web.Response(text=json.dumps({"mensaje": "Preferencias actualizadas correctamente"}), content_type='application/json')

# ── Empleados Export ───────────────────────────────────
async def export_empleados_pdf(request):
    try:
        busqueda = request.rel_url.query.get('busqueda', '').strip()
        async with request.app['db'].acquire() as conn:
            async with conn.cursor(aiomysql.DictCursor) as cur:
                if busqueda:
                    await cur.execute(
                        "SELECT id, nombre, puesto, salario, email FROM empleados WHERE nombre LIKE %s OR email LIKE %s",
                        (f'%{busqueda}%', f'%{busqueda}%')
                    )
                else:
                    await cur.execute("SELECT id, nombre, puesto, salario, email FROM empleados")
                empleados = await cur.fetchall()

        html = """<html><head><meta charset='utf-8'>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            h1 { color: #1e3a5f; } h3 { color: #555; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th { background-color: #1e3a5f; color: white; padding: 10px; text-align: left; }
            td { padding: 8px 10px; border-bottom: 1px solid #ddd; }
            tr:nth-child(even) { background-color: #f2f2f2; }
        </style></head><body>
        <h1>Lista de Empleados - Motrix</h1>"""
        if busqueda:
            html += f"<h3>Filtro: {busqueda}</h3>"
        html += "<table><tr><th>ID</th><th>Nombre</th><th>Puesto</th><th>Salario</th><th>Email</th></tr>"
        for e in empleados:
            html += f"<tr><td>{e['id']}</td><td>{e['nombre']}</td><td>{e['puesto']}</td><td>${e['salario']:,.2f}</td><td>{e['email']}</td></tr>"
        html += "</table></body></html>"

        return web.Response(
            body=html.encode('utf-8'), content_type='text/html',
            headers={'Content-Disposition': 'attachment; filename="empleados.html"'}
        )
    except aiomysql.Error as e:
        return web.Response(text=json.dumps({"error": f"Error de BD: {str(e)}"}), content_type='application/json', status=500)
    except Exception as e:
        return web.Response(text=json.dumps({"error": f"Error inesperado: {str(e)}"}), content_type='application/json', status=500)

async def export_empleados_csv(request):
    try:
        busqueda = request.rel_url.query.get('busqueda', '').strip()
        async with request.app['db'].acquire() as conn:
            async with conn.cursor(aiomysql.DictCursor) as cur:
                if busqueda:
                    await cur.execute(
                        "SELECT id, nombre, puesto, salario, email FROM empleados WHERE nombre LIKE %s OR email LIKE %s",
                        (f'%{busqueda}%', f'%{busqueda}%')
                    )
                else:
                    await cur.execute("SELECT id, nombre, puesto, salario, email FROM empleados")
                empleados = await cur.fetchall()

        csv_content = "ID,Nombre,Puesto,Salario,Email\n"
        for e in empleados:
            csv_content += f"{e['id']},{e['nombre']},{e['puesto']},{e['salario']},{e['email']}\n"

        return web.Response(
            body=csv_content.encode('utf-8'), content_type='text/csv',
            headers={'Content-Disposition': 'attachment; filename="empleados.csv"'}
        )
    except aiomysql.Error as e:
        return web.Response(text=json.dumps({"error": f"Error de BD: {str(e)}"}), content_type='application/json', status=500)
    except Exception as e:
        return web.Response(text=json.dumps({"error": f"Error inesperado: {str(e)}"}), content_type='application/json', status=500)

# ── Vehículos Export ───────────────────────────────────
async def export_vehiculos_pdf(request):
    try:
        busqueda = request.rel_url.query.get('busqueda', '').strip()
        tipo     = request.rel_url.query.get('tipo', '').strip()

        async with request.app['db'].acquire() as conn:
            async with conn.cursor(aiomysql.DictCursor) as cur:
                sql    = "SELECT id, tipo, marca, modelo, precio, descripcion FROM vehiculos WHERE 1=1"
                params = []
                if busqueda:
                    sql += " AND (marca LIKE %s OR modelo LIKE %s)"
                    params += [f'%{busqueda}%', f'%{busqueda}%']
                if tipo:
                    sql += " AND tipo = %s"
                    params.append(tipo)
                await cur.execute(sql, params)
                vehiculos = await cur.fetchall()

        html = """<html><head><meta charset='utf-8'>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            h1 { color: #1e3a5f; } h3 { color: #555; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th { background-color: #1e3a5f; color: white; padding: 10px; text-align: left; }
            td { padding: 8px 10px; border-bottom: 1px solid #ddd; }
            tr:nth-child(even) { background-color: #f2f2f2; }
        </style></head><body>
        <h1>Vehículos Publicados - Motrix</h1>"""
        if busqueda or tipo:
            html += f"<h3>Filtros: {'Búsqueda: '+busqueda if busqueda else ''} {'Tipo: '+tipo if tipo else ''}</h3>"
        html += "<table><tr><th>ID</th><th>Tipo</th><th>Marca</th><th>Modelo</th><th>Precio</th><th>Descripción</th></tr>"
        for v in vehiculos:
            html += f"<tr><td>{v['id']}</td><td>{v['tipo']}</td><td>{v['marca']}</td><td>{v['modelo']}</td><td>${v['precio']:,.2f}</td><td>{v['descripcion'] or ''}</td></tr>"
        html += "</table></body></html>"

        return web.Response(
            body=html.encode('utf-8'), content_type='text/html',
            headers={'Content-Disposition': 'attachment; filename="vehiculos.html"'}
        )
    except aiomysql.Error as e:
        return web.Response(text=json.dumps({"error": f"Error de BD: {str(e)}"}), content_type='application/json', status=500)
    except Exception as e:
        return web.Response(text=json.dumps({"error": f"Error inesperado: {str(e)}"}), content_type='application/json', status=500)

async def export_vehiculos_csv(request):
    try:
        busqueda = request.rel_url.query.get('busqueda', '').strip()
        tipo     = request.rel_url.query.get('tipo', '').strip()

        async with request.app['db'].acquire() as conn:
            async with conn.cursor(aiomysql.DictCursor) as cur:
                sql    = "SELECT id, tipo, marca, modelo, precio, descripcion FROM vehiculos WHERE 1=1"
                params = []
                if busqueda:
                    sql += " AND (marca LIKE %s OR modelo LIKE %s)"
                    params += [f'%{busqueda}%', f'%{busqueda}%']
                if tipo:
                    sql += " AND tipo = %s"
                    params.append(tipo)
                await cur.execute(sql, params)
                vehiculos = await cur.fetchall()

        csv_content = "ID,Tipo,Marca,Modelo,Precio,Descripcion\n"
        for v in vehiculos:
            desc = str(v['descripcion'] or '').replace(',', ';')
            csv_content += f"{v['id']},{v['tipo']},{v['marca']},{v['modelo']},{v['precio']},{desc}\n"

        return web.Response(
            body=csv_content.encode('utf-8'), content_type='text/csv',
            headers={'Content-Disposition': 'attachment; filename="vehiculos.csv"'}
        )
    except aiomysql.Error as e:
        return web.Response(text=json.dumps({"error": f"Error de BD: {str(e)}"}), content_type='application/json', status=500)
    except Exception as e:
        return web.Response(text=json.dumps({"error": f"Error inesperado: {str(e)}"}), content_type='application/json', status=500)

# ── Roles ──────────────────────────────────────────────
async def check_role(request):
    try:
        data = await request.json()
    except Exception:
        return web.Response(text=json.dumps({"error": "Body inválido, se esperaba JSON"}), content_type='application/json', status=400)

    email = data.get("email", "").strip()
    if not email:
        return web.Response(text=json.dumps({"error": "El campo email es requerido"}), content_type='application/json', status=400)
    if "@" not in email or "." not in email:
        return web.Response(text=json.dumps({"error": "El email no tiene un formato válido"}), content_type='application/json', status=400)

    try:
        async with request.app['db'].acquire() as conn:
            async with conn.cursor(aiomysql.DictCursor) as cur:
                await cur.execute("SELECT role FROM users WHERE email = %s", (email,))
                user = await cur.fetchone()
    except aiomysql.Error as e:
        return web.Response(text=json.dumps({"error": f"Error de base de datos: {str(e)}"}), content_type='application/json', status=500)
    except Exception as e:
        return web.Response(text=json.dumps({"error": f"Error inesperado: {str(e)}"}), content_type='application/json', status=500)

    if not user:
        return web.Response(text=json.dumps({"error": "Usuario no encontrado"}), content_type='application/json', status=404)
    if not user.get("role"):
        return web.Response(text=json.dumps({"error": "El usuario no tiene rol asignado"}), content_type='application/json', status=422)

    return web.Response(text=json.dumps({"role": user["role"]}), content_type='application/json', status=200)

# ── NUEVO: Validación de Empleados ─────────────────────
async def validar_empleado(request):
    try:
        data = await request.json()
    except Exception:
        return web.Response(
            text=json.dumps({"valido": False, "errores": {"general": "El cuerpo de la solicitud no es JSON válido"}}),
            content_type='application/json', status=400
        )

    errores = {}

    # Validar nombre
    nombre = str(data.get('nombre', '')).strip()
    if not nombre:
        errores['nombre'] = 'El nombre es obligatorio.'
    elif len(nombre) < 3:
        errores['nombre'] = 'El nombre debe tener al menos 3 caracteres.'
    elif len(nombre) > 100:
        errores['nombre'] = 'El nombre no puede superar los 100 caracteres.'
    elif not re.match(r'^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$', nombre):
        errores['nombre'] = 'El nombre solo puede contener letras y espacios.'

    # Validar puesto
    puesto = str(data.get('puesto', '')).strip()
    if not puesto:
        errores['puesto'] = 'El puesto es obligatorio.'
    elif len(puesto) < 3:
        errores['puesto'] = 'El puesto debe tener al menos 3 caracteres.'
    elif len(puesto) > 100:
        errores['puesto'] = 'El puesto no puede superar los 100 caracteres.'
    elif not re.match(r'^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$', puesto):
        errores['puesto'] = 'El puesto solo puede contener letras y espacios.'

    # Validar salario
    salario_raw = data.get('salario', '')
    try:
        salario = float(str(salario_raw).strip())
        if salario <= 0:
            errores['salario'] = 'El salario debe ser un valor mayor a cero.'
        elif salario < 100000:
            errores['salario'] = 'El salario mínimo permitido es de $100,000.'
        elif salario > 99999999:
            errores['salario'] = 'El salario no puede superar los $99,999,999.'
    except (ValueError, TypeError):
        errores['salario'] = 'El salario debe ser un número válido.'

    # Validar email
    email = str(data.get('email', '')).strip()
    if not email:
        errores['email'] = 'El correo electrónico es obligatorio.'
    elif not re.match(r'^[^@\s]+@[^@\s]+\.[^@\s]+$', email):
        errores['email'] = 'El correo electrónico no tiene un formato válido.'
    elif len(email) > 150:
        errores['email'] = 'El correo electrónico no puede superar los 150 caracteres.'
    else:
        # Verificar que el email no esté ya registrado en empleados
        try:
            async with request.app['db'].acquire() as conn:
                async with conn.cursor(aiomysql.DictCursor) as cur:
                    empleado_id = data.get('id')  # Si viene id, es edición
                    if empleado_id:
                        await cur.execute(
                            "SELECT id FROM empleados WHERE email = %s AND id != %s",
                            (email, empleado_id)
                        )
                    else:
                        await cur.execute("SELECT id FROM empleados WHERE email = %s", (email,))
                    existente = await cur.fetchone()
                    if existente:
                        errores['email'] = 'Ya existe un empleado registrado con este correo electrónico.'
        except aiomysql.Error as e:
            return web.Response(
                text=json.dumps({"valido": False, "errores": {"general": f"Error al verificar el correo: {str(e)}"}}),
                content_type='application/json', status=500
            )

    if errores:
        return web.Response(
            text=json.dumps({"valido": False, "errores": errores}, ensure_ascii=False),
            content_type='application/json', status=422
        )

    return web.Response(
        text=json.dumps({"valido": True, "mensaje": "Los datos del empleado son válidos."}, ensure_ascii=False),
        content_type='application/json', status=200
    )

# ── NUEVO: Validación de Vehículos ─────────────────────
async def validar_vehiculo(request):
    try:
        data = await request.json()
    except Exception:
        return web.Response(
            text=json.dumps({"valido": False, "errores": {"general": "El cuerpo de la solicitud no es JSON válido"}}),
            content_type='application/json', status=400
        )

    errores = {}
    anio_actual = datetime.now().year

    # Validar tipo
    tipo = str(data.get('tipo', '')).strip().lower()
    tipos_validos = ['carro', 'moto', 'camioneta', 'camión', 'bus']
    if not tipo:
        errores['tipo'] = 'El tipo de vehículo es obligatorio.'
    elif tipo not in tipos_validos:
        errores['tipo'] = 'El tipo de vehículo no es válido. Solo se permiten: Carro y Moto.'

    # Validar marca
    marca = str(data.get('marca', '')).strip()
    if not marca:
        errores['marca'] = 'La marca es obligatoria.'
    elif len(marca) < 2:
        errores['marca'] = 'La marca debe tener al menos 2 caracteres.'
    elif len(marca) > 80:
        errores['marca'] = 'La marca no puede superar los 80 caracteres.'
    elif not re.match(r'^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\-]+$', marca):
        errores['marca'] = 'La marca solo puede contener letras, números, espacios y guiones.'

    # Validar modelo
    modelo = str(data.get('modelo', '')).strip()
    if not modelo:
        errores['modelo'] = 'El modelo es obligatorio.'
    elif len(modelo) < 2:
        errores['modelo'] = 'El modelo debe tener al menos 2 caracteres.'
    elif len(modelo) > 80:
        errores['modelo'] = 'El modelo no puede superar los 80 caracteres.'

    # Validar precio
    precio_raw = data.get('precio', '')
    try:
        precio = float(str(precio_raw).strip())
        if precio <= 0:
            errores['precio'] = 'El precio debe ser mayor a cero.'
        elif precio < 1000000:
            errores['precio'] = 'El precio mínimo permitido es de $1,000,000.'
        elif precio > 9999999999:
            errores['precio'] = 'El precio ingresado es demasiado alto.'
    except (ValueError, TypeError):
        errores['precio'] = 'El precio debe ser un número válido.'

    # Validar descripción (opcional pero si viene, validar longitud)
    descripcion = str(data.get('descripcion', '')).strip()
    if descripcion and len(descripcion) > 500:
        errores['descripcion'] = 'La descripción no puede superar los 500 caracteres.'

    if errores:
        return web.Response(
            text=json.dumps({"valido": False, "errores": errores}, ensure_ascii=False),
            content_type='application/json', status=422
        )

    return web.Response(
        text=json.dumps({"valido": True, "mensaje": "Los datos del vehículo son válidos."}, ensure_ascii=False),
        content_type='application/json', status=200
    )

# ── Rutas ──────────────────────────────────────────────
app = web.Application(middlewares=[cors_middleware])
app.router.add_get('/productos',                  get_productos)
app.router.add_get('/producto/{id}',              get_producto)
app.router.add_post('/comprar/{id}',              comprar_producto)
app.router.add_options('/comprar/{id}',           comprar_producto)
app.router.add_get('/motos',                      get_motos)
app.router.add_get('/moto/{id}',                  get_moto)
app.router.add_post('/comprar-moto/{id}',         comprar_moto)
app.router.add_options('/comprar-moto/{id}',      comprar_moto)
app.router.add_get('/reporte',                    get_reporte)
app.router.add_delete('/compras/{id}',            eliminar_compra)
app.router.add_options('/compras/{id}',           eliminar_compra)
app.router.add_get('/configuracion/perfil',       get_perfil)
app.router.add_put('/configuracion/perfil',       editar_perfil)
app.router.add_options('/configuracion/perfil',   editar_perfil)
app.router.add_get('/configuracion/preferencias',     get_preferencias)
app.router.add_put('/configuracion/preferencias',     actualizar_preferencias)
app.router.add_options('/configuracion/preferencias', actualizar_preferencias)
app.router.add_get('/empleados/export/pdf',       export_empleados_pdf)
app.router.add_get('/empleados/export/csv',       export_empleados_csv)
app.router.add_get('/vehiculos/export/pdf',       export_vehiculos_pdf)
app.router.add_get('/vehiculos/export/csv',       export_vehiculos_csv)
app.router.add_post('/check-role',                check_role)
app.router.add_options('/check-role',             check_role)
# ── Nuevas rutas de validación ─────────────────────────
app.router.add_post('/validar/empleado',          validar_empleado)
app.router.add_options('/validar/empleado',       validar_empleado)
app.router.add_post('/validar/vehiculo',          validar_vehiculo)
app.router.add_options('/validar/vehiculo',       validar_vehiculo)

app.on_startup.append(get_pool)
app.on_cleanup.append(close_pool)

if __name__ == '__main__':
    print("Microservicio Python corriendo en http://0.0.0.0:8080")
    web.run_app(app, host='0.0.0.0', port=8080)