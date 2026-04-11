import aiomysql

async def get_pool(app):
    app['db'] = await aiomysql.create_pool(
        host='127.0.0.1',
        port=3306,
        user='tu_usuario',
        password='tu_password',
        db='tu_base_de_datos',
        autocommit=True
    )

async def close_pool(app):
    app['db'].close()
    await app['db'].wait_closed()