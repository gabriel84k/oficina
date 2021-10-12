export function Rulesname() {


    var nameRules= [
        (v) => !!v || "Este Campo es requerido",
        (v) => v.length <= 10 || "Name must be less than 10 characters",
        ]
    return nameRules
}
export function Rulesnumber() {
    var numberRules= [
        (v) => !!v || "Solo Valores numéricos",
        (v) => /^[0-9]{1,16}$/.test(v) || "Valor no Valido",
    ]
    return numberRules
}
export function Rulesdecimal() {
    var decimalRules= [
        (v) => !!v || "Solo Valores numéricos",
        (v) => /^[0-9,]{1,16}$/.test(v) || "Valor no Valido",
    ]
    return decimalRules

}
export function Rulestext() {
    var textRules= [
        (v) => !!v || "Solo Valor Texto",
        (v) => /^[a-z A-Z]{1,16}$/.test(v) || "Valor no Valido",
    ]
    return textRules

}