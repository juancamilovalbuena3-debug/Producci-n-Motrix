from fastapi import APIRouter

router = APIRouter()

@router.get("/configuracion")
def obtener_configuracion():
    return {
        "perfil": "ok",
        "preferencias": "ok"
    }

@router.post("/perfil")
def actualizar_perfil(data: dict):
    return {
        "mensaje": "Perfil actualizado",
        "datos": data
    }

@router.post("/preferencias")
def actualizar_preferencias(data: dict):
    return {
        "mensaje": "Preferencias actualizadas",
        "datos": data
    }