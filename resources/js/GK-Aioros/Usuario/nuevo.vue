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
                                                    v-model="obj.name"
                                                    label="Nombre Usuario"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.email"
                                                    label="Email"
                                                    
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field
                                                    v-model="obj.password"
                                                    label="Password"
                                                    
                                                ></v-text-field>
                                            </v-col>
                                             <v-col v-if="getUsuario.tipo_id <= 2" cols="12" md="3">
                                                <v-container
                                                    class="px-0"
                                                    fluid
                                                >
                                                    <v-switch
                                                    v-model="obj.estado"
                                                    :label="(obj.estado == 1)?'Activo':'Inactivo'"
                                                    ></v-switch>
                                                </v-container>
                                            </v-col>
                                        </v-row>
                                        <!-- Aquí comiensa cliente y permisos -->
                                        <v-row>
                                            <v-col cols="12" md="4" v-if="getUsuario.tipo_id <= 2">
                                                <v-combobox
                                                    :items="itemTipo"
                                                    v-model="itemTipo[obj.tipo_id - 1]"
                                                    :search-input.sync="search"
                                                    hide-selected
                                                    hint=""
                                                    label="Busqueda Tipo de Usuario"
                                                    :allow-overflow="false"
                                                    :return-object="true"
                                                    persistent-hint
                                                    small-chips
                                                    @change="selecttipo"
                                                    >
                                                    <template v-slot:no-data>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                        <v-list-item-title>
                                                            No existen resulstados "<strong>{{
                                                            search
                                                            }}</strong
                                                            >"
                                                        </v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    </template>
                                                </v-combobox>
                                                
                                            </v-col>
                                            <v-col cols="12" md="4" v-if="getUsuario.tipo_id <= 2">
                                                <v-combobox
                                                    :items="itemSistema"
                                                    item-value="id"
                                                    item-text="nombre"
                                                    :search-input.sync="search"
                                                    hide-selected
                                                    hint=""
                                                    label="Busqueda Sistemas"
                                                    :allow-overflow="false"
                                                    :return-object="true"
                                                    persistent-hint
                                                    small-chips
                                                    @change="selectsistema"
                                                    >
                                                    <template v-slot:no-data>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                        <v-list-item-title>
                                                            No existen resulstados "<strong>{{
                                                            search
                                                            }}</strong
                                                            >"
                                                        </v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    </template>
                                                </v-combobox>
                                                
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                         
                                            <v-col cols="12" md="12">
                                                
                                                <v-divider></v-divider>   <br/>
                                                <v-tabs v-model="tab" >
                                                    <v-tab >Cliente</v-tab>
                                                    <v-tab >Permisos</v-tab>
                                                   
                                                    
                                                </v-tabs>
                                                <v-tabs-items v-model="tab" >
                                                    <v-tab-item>
                                                        <idCliente v-if="getUsuario.tipo_id <= 3" :cliente="obj.cliente"></idCliente>
                                                    </v-tab-item>
                                                    <v-tab-item>
                                                        <v-container>
                                                            <permiso v-if="getUsuario.tipo_id <= 2" :permisos="this.getPermiso"></permiso>
                                                        </v-container>
                                                    </v-tab-item>
                                                </v-tabs-items>
                                                <v-divider></v-divider>
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
import idCliente from './isCliente'
import permiso from './permisos'

export default {
    //components: { view },
    props:['user','tipo','view'],
    data() {
        return {
            dialog: false,
            itemSistema:[],
            selectsistema:[],
            tab: null,
            ex4:'',
            menu: false,
            load:false,
            search: "",
            page: "/home/Users/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            someData:'',
            valid: false,
            itemTipo:[],
            obj:{   name:"",
                    password:'', 
                    email:"",
                    estado:"",
                    permisos:{}, 
                    tipo_id:0,
                    cliente:{}
            },
        }
    },
    watch:{
        dialog(val){
            
            if (val){
                if (this.user.name !== undefined){
                    this.obj={  name:this.user.name, 
                                password:'', 
                                email:this.user.email, 
                                estado: this.user.estado,
                                permisos:{},
                                tipo_id:this.user.tipo_id,
                                cliente : this.user.cliente
                    }
                }else{
                    this.obj={   name:"",
                                password:'', 
                                email:"",
                                estado:"",
                                permisos:{},
                                tipo_id:0,
                                cliente :{}
                    }
                }
                
                this.listTipo()
                this.combosistema()
            }
        }
    },
    computed:{
        getUsuario(){
            return this.$store.state.a.usuario
        },
        getPermiso(){
            
            return this.$store.state.a.permiso
        }
    },
    components:{
        idCliente,
        permiso
    },
    methods: {
        guardar(){
            let param = this.obj;
            param.permisos = this.getPermiso
            console.log(param)
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
             param.permisos = this.getPermiso
            this.load=true
            console.log(param)
            try {
                axios
                .put(this.page +"/"+ this.user.id, param)
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
       
        selecttipo(t) {
            this.obj.tipo_id = t.value;
        },
        combosistema(){
            try {
                axios
                .get("/home/Aldebaran/Sistema/data")
                .then((response) => {
                    this.itemSistema = response.data.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
        },
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
           
        },
        refresh(){
            this.$emit('refresh','cliente')
        },
        listTipo(){
             try {
                axios
                .get("home/Users/combotipo")
                .then((response) => {
                    this.itemTipo = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
        },
       
        limpiar(){
            this.obj={   name:"",
                        password:'', 
                        email:"",
                        estado:"",
                        permisos:{}, 
                        tipo_id:0,
                        cliente:{}
                        
            }
        }
        
    },

}
</script>