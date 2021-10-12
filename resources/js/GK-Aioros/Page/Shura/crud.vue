<template>
    <div class="text-center">
        <v-dialog v-model="dialog" width="100%">
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    class="mx-2" 
                    :title="(tipo == 'Nuevo')?'Crear Nueva Nota':'Modificar Nota'"
                    fab  
                    outlined 
                    x-small 
                    v-bind="attrs"
                    v-on="on"
                    @click="limpiar"
                    :color="(tipo == 'Nuevo')?'cyan':'cyan'"
                >
                <v-icon v-if="(tipo != 'Nuevo')" dark> mdi-folder-open-outline  </v-icon>
                <v-icon v-else >mdi-microsoft-onenote</v-icon>
                </v-btn>
            </template>
                <v-card>
                    <v-card-title class="blue lighten-1 text-white"> Nota</v-card-title>
                        <v-card-text>
                            <template>
                                <v-form v-model="valid">
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12" md="4">
                                                <v-text-field
                                                    v-model="obj.fecha"
                                                    readonly
                                                    label="Fecha"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <v-text-field
                                                    v-model="obj.titulo"
                                                    label="Titulo"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                               
                                                <ckeditor   :editor="editor" 
                                                            outlined
                                                            v-model="obj.nota"
                                                            name="input-7-4"
                                                            label="Detalle de la Nota"
                                                            value="..."
                                                ></ckeditor>
                                            </v-col>
                                           
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    label="Cliente"
                                                    readonly
                                                    required
                                                ></v-text-field>
                                            </v-col>
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    props:['nota','tipo','isrt'],
    data() {
        return {
            editor:ClassicEditor,
            dialog: false,
            load:false,
            page: "/home/Shura/Nota/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            valid: false,
            obj:{  
                titulo:'',
                fecha:'', 
                nota:'', 
                firma:'', 
                estado:1,  
                cliente_id:0, 
                user_id:0,
            },
        }
    },
    watch:{
        dialog(val){
            if (val){
                if (this.nota.id !== undefined){
                    this.obj={  
                                titulo:this.nota.titulo,
                                fecha:this.nota.fecha,
                                nota:this.nota.nota, 
                                firma:this.nota.firma, 
                                estado:this.nota.estado,  
                                cliente_id:this.nota.cliente_id, 
                                user_id:this.nota.user_id,
                    }
                }else{
                    
                    var f = formatfecha.formatES(new Date())
                    this.obj={ 
                                fecha: f,
                                titulo:'',
                                nota:'', 
                                firma:'', 
                                estado:1,  
                                cliente_id:null, 
                                user_id:0,
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
                        this.refresh()
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
            param.fecha =  formatfecha.formatEN(formatfecha.formatES(new Date()))
            this.load=true
            try {
                axios
                .put(this.page+'/'+this.nota.id, param)
                .then((response) => {
                    this.alerta.mensaje = ''
                    if (response.data.status == 0) {
                        this.alerta.mensaje = "Se Modifico correctamente el Usuario.";
                        this.alerta.tipo = 2;
                        this.alerta.color = 'success';
                        this.alerta.visible = true;
                        this.refresh()
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
                this.load=false
            }
        },
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
        },
        refresh(){
            this.$emit('refresh','nota')
        },
        limpiar(){
            this.obj={  titulo:'',
                        fecha:'', 
                        nota:'', 
                        firma:'', 
                        estado:0,  
                        cliente_id:null, 
                        user_id:0,
                        subobj:{}
            }
        },
    },

}
</script>