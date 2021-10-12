<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="100%">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                class="mx-2" 
                :title="tipo" 
                fab  
                outlined 
                x-small 
                v-bind="attrs"
                v-on="on"
                @click="limpiar"
                :color="(tipo == 'Nuevo')?'withe':'cyan'"
                >
                <v-icon v-if="(tipo != 'Nuevo')" dark> mdi-pencil </v-icon>
                <v-icon v-else >mdi-plus</v-icon>
                </v-btn>
            </template>
                <v-card>
                    <v-card-title class="blue lighten-1 text-white"> {{tipo}} Usuario</v-card-title>
                        <v-card-text>
                            <template>
                                <v-form v-model="valid">
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.fecha"
                                                    readonly
                                                    label="Fecha"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.direccion"
                                                    readonly
                                                    label="Dirección"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.titulo"
                                                    label="Titulo"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Detalle</th>
                                                            <th>Precio</th>
                                                            <th>Cant.</th>
                                                            <th>Total</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <v-text-field
                                                                        v-model="objTemporal.detalle"
                                                                        required
                                                                    ></v-text-field>
                                                                </td>
                                                                <td>
                                                                    <v-text-field
                                                                        v-model="objTemporal.precio"
                                                                        required
                                                                        @change="calculo"
                                                                        prefix="$"
                                                                    ></v-text-field>
                                                                </td>
                                                                <td>
                                                                    <v-text-field
                                                                        v-model="objTemporal.cantidad"
                                                                        required
                                                                        @change="calculo"
                                                                    ></v-text-field>
                                                                </td>
                                                                <td>
                                                                    <v-text-field
                                                                        v-model="objTemporal.total"
                                                                        prefix="$"
                                                                        required
                                                                        readonly
                                                                    ></v-text-field>
                                                                </td>
                                                                <td>
                                                                    <v-btn
                                                                        elevation="6"
                                                                        outlined
                                                                        text
                                                                        x-small
                                                                        @click="agregar(objTemporal)"
                                                                    >Agregar</v-btn>
                                                                </td>
                                                            </tr>
                                                            <tr v-for="(subitem,index) in obj.subobj" :key="index">
                                                                <td>{{index +1 }}</td>
                                                                <td>{{subitem.detalle}}</td>
                                                                <td>{{subitem.precio}}</td>
                                                                <td>{{subitem.cantidad}}</td>
                                                                <td>{{subitem.total}}</td>
                                                                <td>
                                                                    <v-btn
                                                                        elevation="6"
                                                                        outlined
                                                                        text
                                                                        x-small
                                                                        color = 'red'
                                                                        @click="eliminar(subitem)"
                                                                    >Eliminar</v-btn>
                                                                </td>
                                                            </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" class="text-right"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </v-col>
                                           
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    v-model="obj.nota"
                                                    label="Nota"
                                                    required
                                                ></v-text-field>
                                              
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.total"
                                                    label="Total"
                                                     prefix="$"
                                                     readonly
                                                    required
                                                ></v-text-field>
                                              
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    label="Cliente"
                                                    readonly
                                                    required
                                                ></v-text-field>
                                              
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-text-field
                                                    v-model="obj.firma"
                                                    label="Firma"
                                                    required
                                                ></v-text-field>
                                              
                                            </v-col>
                                        </v-row>
                                        
                                    </v-container>
                                </v-form>
                            </template>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <msjAlerta :msj="alerta"></msjAlerta>
                            <v-btn color="primary" text @click="closealert()"> Salir </v-btn>
                            <v-btn v-if="(tipo == 'Nuevo')" color="primary" text @click="guardar()"> Guardar </v-btn>
                            <v-btn v-else color="primary" text @click="modificar()"> Modificar </v-btn>
                        </v-card-actions>
                </v-card>
            </v-dialog>
            <loader :load="load"></loader>
    </div>
</template>

<script>
export default {
    //components: { view },
    props:['presupuesto','tipo','isrt','empresa'],
    data() {
        return {
            dialog: false,
            itemSistema:[],
            tab: null,
            load:false,
            search: "",
            page: "/home/MU/Presupuesto/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            valid: false,
            itemTipo:[],
            obj:{  
                titulo:'',
                fecha:'', 
                direccion:'', 
                total:0, 
                nota:'', 
                firma:'', 
                estado:1,  
                cliente_id:0, 
                user_id:0,
                subobj:{}
            },
            max:0,
            objTemporal:{
                    detalle:'',
                    precio:0,
                    cantidad:0,
                    total:0,
                }
        }
    },
    watch:{
        dialog(val){
            if (val){
                if (this.presupuesto.id !== undefined){
                    this.obj={  
                                titulo:this.presupuesto.titulo,
                                fecha:this.presupuesto.fecha,
                                direccion:this.presupuesto.direccion, 
                                total:this.presupuesto.total, 
                                nota:this.presupuesto.nota, 
                                firma:this.presupuesto.firma, 
                                estado:this.presupuesto.estado,  
                                cliente_id:this.presupuesto.cliente_id, 
                                user_id:this.presupuesto.user_id,
                                subobj:[]
                    }
                }else{
                    
                    var f = formatfecha.formatES(new Date())
                    this.obj={ 
                               
                                fecha: f,
                                titulo:'',
                                direccion: this.empresa.direccion, 
                                total:0, 
                                nota:'', 
                                firma:'', 
                                estado:1,  
                                cliente_id:null, 
                                user_id:0,
                                subobj:[]
                    }
                }
                
            }
        }
    },
    computed:{
        getPermiso(){
            
            return this.$store.state.a.permiso
        }
    },
    methods: {
        
        guardar(){
            let param = this.obj;
            param.fecha =  formatfecha.formatEN(formatfecha.formatES(new Date()))
            this.load=true
            try {
                axios
                .post(this.page, param)
                .then((response) => {
                    if (response.data.status == 0) {
                        //alerta//
                        this.alerta.mensaje = response.data.descripcion;
                        this.alerta.tipo = 2;
                        this.alerta.color = 'success';
                        this.alerta.visible = true;
         
                    } else {
                        if (response.data.descripcion != ""){
                            this.alerta.mensaje = response.data.descripcion;
                        }else{
                            this.alerta.mensaje = funciones.errorjson(response.data.errors)    
                        }
                           this.alerta.tipo = 2;
                            this.alerta.color = 'error';
                            this.alerta.visible = true;
                        
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.load=false
                })
                .finally(() => this.load=false);
            } catch (error) {
                console.log(error);
            }
        },
        modificar(){
            let param = this.obj;
            this.load=true
            try {
                axios
                .put(this.page +"/"+ this.presupuesto.id, param)
                .then((response) => {
                    this.alerta.mensaje = ''
                    if (response.data.status == 0) {
                        //alerta//
                        this.alerta.mensaje = "Se Modifico correctamente el Usuario.";
                        this.alerta.tipo = 2;
                        this.alerta.color = 'success';
                        this.alerta.visible = true;
                        
                    } else {
                        if (response.data.descripcion != ""){
                            this.alerta.mensaje = response.data.descripcion;
                        }else{
                            
                            var errors = JSON.stringify(response.data.errors)
                                                .replace('name','nombre')
                                                .replace('_',' ')
                                                .replace('{','')
                                                .replace('}','')
                                                .split(',')
                            errors.forEach(element => {
                                
                                this.alerta.mensaje += element + ' - '       
                            });
                            this.alerta.tipo = 2;
                            this.alerta.color = 'error';
                            this.alerta.visible = true;
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.load=false
                })
                .finally(() => this.load=false);
            } catch (error) {
                console.log(error);
                this.load=false
            }
        },
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
        },
        refresh(){
            this.$emit('refresh','presupuesto')
        },
        limpiar(){
            this.obj={  titulo:'',
                        fecha:'', 
                        direccion:'', 
                        total:0, 
                        nota:'', 
                        firma:'', 
                        estado:0,  
                        cliente_id:null, 
                        user_id:0,
                        subobj:{}
                        
            }
        },
        agregar(e){
            if (e.total > 0){
                this.obj.subobj.push(e)
                this.objTemporal = { detalle:'',
                                     precio:0,
                                     cantidad:0,
                                     total:0,
                                    }
            }else{
                this.alerta.mensaje = 'No se puede Agregar un total 0.'
                this.alerta.tipo = 2
                this.alerta.color = 'error'
                this.alerta.visible = true
            }
            
        },
        calculo(){
            this.objTemporal.total = this.objTemporal.precio * this.objTemporal.cantidad
            this.obj.total += this.objTemporal.total 
        }
        
    },

}
</script>