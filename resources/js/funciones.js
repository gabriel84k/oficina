export function errorjson(error) {
    var msj= ''
    var errors = JSON.stringify(error)
            .replace('_',' ')
            .replace('{','')
            .replace('}','')
            .split(',')
    errors.forEach(element => {
        msj += element + ' - '       
    });
    return msj
}
export function json_Array(json) {
    let arr=[]
    Object.keys(json).forEach(function(key,element) {
        arr[key] = JSON.parse(json[key])
    })
   
    return arr
}
export function Array_json(array) {
    let arr=[]
    console.log(JSON.parse(JSON.stringify(Object.assign({}, array))))
    Object.keys(array).forEach(function(key,element) {
        arr[key] = JSON.stringify(array[key])
    })
   
    return JSON.parse(JSON.stringify(Object.assign({}, array)))
}
export function json_parse(json) {
    return JSON.parse(json)
}