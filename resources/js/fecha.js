export function formatES(d) {
        return d.toLocaleDateString();
        
}
export function formatEN(d) {
        
        var fecha = d.split('/')
        console.log('fecha en englisj¿h')
        console.log(d)
        return fecha[2]+'-'+fecha[1]+'-'+fecha[0]
           
}
export function formatEN_ES(d) {
        
        var fecha = d.split('-')
       
        return fecha[2]+'/'+fecha[1]+'/'+fecha[0]
           
}
export function formatEN_ES_TiME(d) {
      
        var time = d.split('T')
        var fecha = time[0].split('-')
        var time = time[1].split('.')
       
        return fecha[2]+'/'+fecha[1]+'/'+fecha[0] +'  '+ time[0]
           
}

/* asi se escribe en el log : log.create({'detalle':'hola','tipo':'nuevo producto'}) */