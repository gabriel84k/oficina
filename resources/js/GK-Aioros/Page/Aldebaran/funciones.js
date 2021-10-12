export function prioridad(p) {
    switch (p) {
        case 0:
            return 'Muy Baja'
        case 1:
            return 'Baja'
        case 2:
            return 'Media'
        case 3:
            return 'Alta'
        case 4:
            return 'Muy Alta'
        default:
            return p
    }
}

export function estado(e) {
    switch (e) {
        case 0:
            return 'Iniciado'
        case 1:
            return 'En Proceso'
        case 2:
            return 'Derivado'
        case 3:
            return 'Finalizado'
        case 4:
            return 'Cancelado'
        default:
            return e
    }
}
export function tecnicoOcliente(item,ticket) {
   
    if (item.user_id !== null){
        return item.tecnico.name
    }else{
        return ticket.nombre
    }
    
}