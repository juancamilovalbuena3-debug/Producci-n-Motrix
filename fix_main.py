content = """from aiohttp import web
import json

carros = {
    1: {"id": 1, "nombre": "Toyota Corolla 2023", "precio": 85000000, "transmision": "Automatico", "combustible": "Gasolina", "imagen": "images/carros/Toyota Corolla 2023.jpg"},
    2: {"id": 2, "nombre": "Mazda CX-5 2022", "precio": 120000000, "transmision": "Automatico", "combustible": "Diesel", "imagen": "images/carros/Mazda.jpg"},
    3: {"id": 3, "nombre": "Ford EcoSport 2022", "precio": 95000000, "transmision": "Automatico", "combustible": "Gasolina", "imagen": "images/carros/Ford.jpg"},
    4: {"id": 4, "nombre": "Hyundai Tucson 2023", "precio": 130000000, "transmision": "Automatico", "combustible": "Diesel", "imagen": "images/carros/Hyundai.jpg"},
    5: {"id": 5, "nombre": "Volkswagen Golf 2021", "precio": 88000000, "transmision": "Automatico", "combustible": "Gasolina", "imagen": "images/carros/golf.jpg"},
}

motos = {
    1: {"id": 1, "nombre": "Yamaha MT-07 2022", "precio": 32000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/Yamaha MT-07 2022.jpg"},
    2: {"id": 2, "nombre": "Honda CBR500R", "precio": 28000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/honda-cbr500r.jpg"},
    3: {"id": 3, "nombre": "Kawasaki Ninja 650 2023", "precio": 35000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/Kawasaki Ninja 650 2023.jpg"},
    4: {"id": 4, "nombre": "KTM Duke 390 2023", "precio": 22000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/KTM Duke 390 2023.jpg"},
    5: {"id": 5, "nombre": "BMW G310R 2022", "precio": 25000000, "transmision": "Manual", "combustible": "Gasolina", "imagen": "images/motos/BMW G310R 2022.jpg"},
}

compras = []

@web.middleware
async def cors_middleware(request, handler):
    if request.method == 'OPTIONS':
        return web.Response(headers={'Access-Control-Allow-Origin': '*', 'Access-Control-Allow-Methods': 'GET, POST, OPTIONS', 'Access-Control-Allow-Headers': 'Content-Type'})
    response = await handler(request)
    response.headers['Access-Control-Allow-Origin'] = '*'
    return response

async def get_productos(request):
    return web.Response(text=json.dumps(list(carros.values()), ensure_ascii=False), content_type='application/json')

async def get_producto(request):
    carro_id = int(request.match_info['id'])
    carro = carros.get(carro_id)
    if not carro:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)
    return web.Response(text=json.dumps(carro, ensure_ascii=False), content_type='application/json')

async def comprar_producto(request):
    carro_id = int(request.match_info['id'])
    carro = carros.get(carro_id)
    if not carro:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)
    compra = {"id_compra": len(compras) + 1, "vehiculo": carro['nombre'], "precio": carro['precio'], "estado": "Compra exitosa"}
    compras.append(compra)
    return web.Response(text=json.dumps(compra, ensure_ascii=False), content_type='application/json')

async def get_motos(request):
    return web.Response(text=json.dumps(list(motos.values()), ensure_ascii=False), content_type='application/json')

async def get_moto(request):
    moto_id = int(request.match_info['id'])
    moto = motos.get(moto_id)
    if not moto:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)
    return web.Response(text=json.dumps(moto, ensure_ascii=False), content_type='application/json')

async def comprar_moto(request):
    moto_id = int(request.match_info['id'])
    moto = motos.get(moto_id)
    if not moto:
        return web.Response(text=json.dumps({"error": "No encontrado"}), content_type='application/json', status=404)
    compra = {"id_compra": len(compras) + 1, "vehiculo": moto['nombre'], "precio": moto['precio'], "estado": "Compra exitosa"}
    compras.append(compra)
    return web.Response(text=json.dumps(compra, ensure_ascii=False), content_type='application/json')

app = web.Application(middlewares=[cors_middleware])
app.router.add_get('/productos', get_productos)
app.router.add_get('/producto/{id}', get_producto)
app.router.add_post('/comprar/{id}', comprar_producto)
app.router.add_options('/comprar/{id}', comprar_producto)
app.router.add_get('/motos', get_motos)
app.router.add_get('/moto/{id}', get_moto)
app.router.add_post('/comprar-moto/{id}', comprar_moto)
app.router.add_options('/comprar-moto/{id}', comprar_moto)

if __name__ == '__main__':
    print("Microservicio Python corriendo en http://0.0.0.0:8080")
    web.run_app(app, host='0.0.0.0', port=8080)
"""

with open(r'C:\\Users\\adminsena\\Downloads\\motrixpython-main\\microservicio\\main.py', 'w') as f:
    f.write(content)
print('main.py guardado OK')