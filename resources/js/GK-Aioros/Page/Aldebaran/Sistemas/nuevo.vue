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
                                                    v-model="obj.nombre"
                                                    label="Nombre Sistema"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.empresa"
                                                    label="Empresa"
                                                    
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.nota"
                                                    label="Nota"
                                                    
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
    
    props:['sistema','tipo'],
    data() {
        return {
            dialog: false,
            load:false,
            search: "",
            page: "/home/Aldebaran/Sistema/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            valid: false,
            itemTipo:[],
            obj:{   nombre:"",
                    empresa:'', 
                    nota:"",
            },
        }
    },
    watch:{
        dialog(val){
            if (val){
                if (this.sistema.nombre !== undefined){
                    this.obj={     
                        nombre:this.sistema.nombre, 
                        empresa:this.sistema.empresa, 
                        nota:this.sistema.nota, 
                    }
                }else{
                    this.obj={  nombre:"",
                                empresa:'', 
                                nota:"",
                    }
                }
            }
        }
    },
    
    methods: {
        guardar(){
            let param = this.obj;
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
                        this.refresh();
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
                .put(this.page +"/"+ this.sistema.id, param)
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
            this.$emit('refresh','cliente')
        },
       
        limpiar(){
            this.obj={  nombre:"",
                        empresa:'', 
                        nota:"",
            }
        },
        closealert(){
            this.dialog=false
        }
        
    },

}
</script>