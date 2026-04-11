from aiohttp import web
import aiomysql

async def obtener_producto(request):
    producto_id = request.match_info['id']

    return web.json_response({
        "id": producto_id,
        "nombre": "Vehiculo Demo",
        "precio": 50000000
    })

async def comprar(request):
    data = await request.json()

    return web.json_response({
        "mensaje": "Compra registrada",
        "producto_id": data.get("producto_id"),
        "usuario_id": data.get("usuario_id")
    })

app = web.Application()

app.router.add_get('/producto/{id}', obtener_producto)
app.router.add_post('/comprar', comprar)

web.run_app(app, port=8001)