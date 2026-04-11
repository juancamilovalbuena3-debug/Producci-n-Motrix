from aiohttp import web
import bcrypt

# PUT /configuracion/perfil
async def editar_perfil(request):
    data = await request.json()
    user_id = data.get('user_id')
    nombre   = data.get('nombre')
    correo   = data.get('correo')
    password = data.get('password')  # opcional

    #if not user_id or not nombre or not correo:
        #return web.json_response({'error': 'Faltan campos requeridos'}, status=400)
    try:
        user_id = data.get('user_id')
        nombre   = data.get('nombre')
        correo   = data.get('correo')
    except Exception:
        return web.Response(
           {'error': 'Faltan campos requeridos'}, status=400
        )

    async with request.app['db'].acquire() as conn:
        async with conn.cursor() as cur:
            if password:
                hashed = bcrypt.hashpw(password.encode(), bcrypt.gensalt()).decode()
                await cur.execute(
                    "UPDATE usuarios SET nombre=%s, correo=%s, password=%s WHERE id=%s",
                    (nombre, correo, hashed, user_id)
                )
            else:
                await cur.execute(
                    "UPDATE usuarios SET nombre=%s, correo=%s WHERE id=%s",
                    (nombre, correo, user_id)
                )

    return web.json_response({'mensaje': 'Perfil actualizado correctamente'})


# PUT /configuracion/preferencias
async def actualizar_preferencias(request):
    data = await request.json()
    user_id      = data.get('user_id')
    preferencias = data.get('preferencias')  # dict con las preferencias

    if not user_id or not preferencias:
        return web.json_response({'error': 'Faltan campos requeridos'}, status=400)

    import json
    async with request.app['db'].acquire() as conn:
        async with conn.cursor() as cur:
            await cur.execute(
                "UPDATE usuarios SET preferencias=%s WHERE id=%s",
                (json.dumps(preferencias), user_id)
            )

    return web.json_response({'mensaje': 'Preferencias actualizadas correctamente'})
