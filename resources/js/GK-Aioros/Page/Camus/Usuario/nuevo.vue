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
                                             <v-col cols="12" md="3">
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
                                       
                                        <v-row v-if="user.tipo_id == 1 || tipo == 'Nuevo' || isrt == 1">
                                           <br>
                                            <v-col cols="12" md="12">
                                                <div>
                                                    <v-row>
                                                        <v-col cols="12" md="2" class="border">
                                                            <h4 class="red--text">Menus</h4>
                                                            <hr>
                                                            
                                                            <v-checkbox
                                                                v-model="obj.permisos.menu.cliente"
                                                                label="Cliente"
                                                                color="success"
                                                                :value="obj.permisos.menu.cliente"
                                                                hide-details
                                                            >
                                                            </v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.menu.producto"
                                                                label="Producto"
                                                                color="success"
                                                                :value="obj.permisos.menu.producto"
                                                                hide-details
                                                            >
                                                            </v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.menu.usuario"
                                                                label="Usuario"
                                                                color="success"
                                                                :value="obj.permisos.menu.usuario"
                                                                hide-details
                                                            >
                                                            </v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.menu.reporte"
                                                                label="Reporte"
                                                                color="success"
                                                                :value="obj.permisos.menu.reporte"
                                                                hide-details
                                                            >
                                                            </v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.menu.config"
                                                                label="Configuración"
                                                                color="success"
                                                                :value="obj.permisos.menu.config"
                                                                hide-details
                                                            >
                                                            </v-checkbox>
                                                        </v-col>
                                                        <v-col cols="12" md="2">
                                                            <h4 class="red--text">Cliente</h4>
                                                            <hr>
                                                            <v-checkbox
                                                                v-model="obj.permisos.cliente.nuevo"
                                                                label="Nuevo"
                                                                color="success"
                                                                :value="obj.permisos.cliente.nuevo"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.cliente.modificar"
                                                                label="Modificación"
                                                                color="success"
                                                                :value="obj.permisos.cliente.modificar"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.cliente.eliminar"
                                                                label="Eliminación"
                                                                color="success"
                                                                :value="obj.permisos.cliente.eliminar"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.cliente.asociar"
                                                                label="Asociar Producto"
                                                                color="success"
                                                                :value="obj.permisos.cliente.asociar"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.cliente.modificarasociado"
                                                                label="Modificar Producto Asociado"
                                                                color="success"
                                                                :value="obj.permisos.cliente.modificarasociado"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.cliente.pago"
                                                                label="Pago Producto"
                                                                color="success"
                                                                :value="obj.permisos.cliente.pago"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.cliente.editpago"
                                                                label="Modificar Pago de Prod."
                                                                color="success"
                                                                :value="obj.permisos.cliente.editpago"
                                                                hide-details
                                                            ></v-checkbox>
                                                             
                                                        </v-col>
                                                        <v-col cols="12" md="2">
                                                            <h4 class="red--text">Usuario</h4>
                                                            <hr>
                                                            <v-checkbox
                                                                v-model="obj.permisos.usuario.nuevo"
                                                                label="Nuevo"
                                                                color="success"
                                                                :value="obj.permisos.usuario.nuevo"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.usuario.modificar"
                                                                label="Modificación"
                                                                color="success"
                                                                :value="obj.permisos.usuario.modificar"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.usuario.eliminar"
                                                                label="Eliminación"
                                                                color="success"
                                                                :value="obj.permisos.usuario.eliminar"
                                                                hide-details
                                                            ></v-checkbox>
                                                        </v-col>
                                                        <v-col cols="12" md="2">
                                                            <h4 class="red--text">Producto</h4>
                                                            <hr>
                                                            <v-checkbox
                                                                v-model="obj.permisos.producto.nuevo"
                                                                label="Nuevo"
                                                                color="success"
                                                                :value="obj.permisos.producto.nuevo"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.producto.modificar"
                                                                label="Modificación"
                                                                color="success"
                                                                :value="obj.permisos.producto.modificar"
                                                                hide-details
                                                            ></v-checkbox>
                                                            <v-checkbox
                                                                v-model="obj.permisos.producto.eliminar"
                                                                label="Eliminación"
                                                                color="success"
                                                                :value="obj.permisos.producto.eliminar"
                                                                hide-details
                                                            ></v-checkbox>
                                                        </v-col>
                                                        <v-col cols="12" md="2">
                                                            <h4 class="red--text">Reporte</h4>
                                                            <hr>
                                                            <v-checkbox
                                                                v-model="obj.permisos.reporte.modificar"
                                                                label="visible"
                                                                color="success"
                                                                :value="obj.permisos.reporte.modificar"
                                                                hide-details
                                                            ></v-checkbox>
                                                        </v-col>
                                                        <v-col cols="12" md="2">
                                                            <h4 class="red--text">Configuración</h4>
                                                            <hr>
                                                            <v-checkbox
                                                                v-model="obj.permisos.config.eliminar"
                                                                label="Visible"
                                                                color="success"
                                                                :value="obj.permisos.config.eliminar"
                                                                hide-details
                                                            ></v-checkbox>
                                                        </v-col>
                                                    </v-row>
                                                    <v-row>
                                                        <v-col cols="12" md="4">
                                                            <v-combobox
                                                                :items="itemTipo"
                                                                v-model="itemTipo[obj.tipo_id - 1]"
                                                                :search-input.sync="search"
                                                                hide-selected
                                                                hint=""
                                                                label="Busqueda Tipo de Empleado"
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
                                                        <v-col cols="12" md="4">
                                                            <v-combobox
                                                                :items="itemZona"
                                                                v-model="obj.zona"
                                                                item-text='nombre'
                                                                item-value='id'
                                                                :search-input.sync="search"
                                                                hide-selected
                                                                hint=""
                                                                multiple
                                                                label="Zona Asignada"
                                                                :allow-overflow="false"
                                                                :return-object="true"
                                                                persistent-hint
                                                                small-chips
                                                                @change="selectZona"
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
                                                </div>
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
import view from '../Menu/view'

export default {
  components: { view },
    props:['user','tipo','isrt'],
    data() {
        return {
            dialog: false,
            ex4:'',
            menu: false,
            load:false,
            search: "",
            page: "/home/Camus/Users/data",
            alerta: { mensaje: "", visible: false, tipo: 0 },
            someData:'',
            valid: false,
            itemTipo:[],
            itemZona:[],
            obj:{   name:"",
                    password:'', 
                    email:"",
                    estado:"",
                    permisos:{  menu:{"usuario":false,"cliente":false,"producto":false,"reporte":false,"config":false},
                                cliente:{"nuevo":false,"modificar":false,"eliminar":false,"asociar":false,'modificarasociado':false,"pago":false},
                                usuario:{"nuevo":false,"modificar":false,"eliminar":false},
                                producto:{"nuevo":false,"modificar":false,"eliminar":false},
                                reporte:{"nuevo":false,"modificar":false,"eliminar":false},
                                config:{"nuevo":false,"modificar":false,"eliminar":false},
                              }, 
                    tipo_id:0,
                    zona_id:0   
            },
            Rules: {
                nameRules: [
                (v) => !!v || "Este Campo es requerido",
                (v) => v.length <= 10 || "Name must be less than 10 characters",
                ],
                numberRules: [
                (v) => !!v || "Solo Valores numéricos",
                (v) => /^[0-9]{1,16}$/.test(v) || "Valor no Valido",
                ],
                decimalRules: [
                (v) => !!v || "Solo Valores numéricos",
                (v) => /^[0-9,]{1,16}$/.test(v) || "Valor no Valido",
                ],
            },
        }
    },
    watch:{
        dialog(val){
            console.log('isroot')
            console.log(this.isrt)
            if (val){
            
              
                if (this.user.name !== undefined){
                    this.obj={  name:this.user.name, 
                                password:'', 
                                email:this.user.email, 
                                estado: this.user.estado,
                                permisos:{menu:JSON.parse(this.user.permisos.menu),
                                        cliente:JSON.parse(this.user.permisos.cliente),
                                        usuario:JSON.parse(this.user.permisos.usuario),
                                        producto:JSON.parse(this.user.permisos.producto),
                                        reporte:JSON.parse(this.user.permisos.reporte),
                                        config:JSON.parse(this.user.permisos.config),  
                                        },
                                tipo_id:this.user.tipo_id,
                                zona:this.user.zona
                    }
                }else{
                    this.obj={   name:"",
                                password:'', 
                                email:"",
                                estado:"",
                                permisos:{  menu:{"usuario":false,"cliente":false,"producto":false,"reporte":false,"config":false},
                                            cliente:{"nuevo":false,"modificar":false,"eliminar":false,"asociar":false,'modificarasociado':false,"pago":false,"editpago":false},
                                            usuario:{"nuevo":false,"modificar":false,"eliminar":false},
                                            producto:{"nuevo":false,"modificar":false,"eliminar":false},
                                            reporte:{"nuevo":false,"modificar":false,"eliminar":false},
                                            config:{"nuevo":false,"modificar":false,"eliminar":false},
                                        }, 
                                tipo_id:0,
                                zona:[]
                    }
                }
                this.listTipo()
                this.listZona()
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
                        this.alerta.tipo = 1;
                        this.alerta.visible = true;
                        this.refresh();
                    } else {
                        if (response.data.descripcion != ""){
                            this.alerta.mensaje = response.data.descripcion;
                        }else{
                            
                            var errors = JSON.stringify(response.data.errors)
                                                .replace('_',' ')
                                                .replace('{','')
                                                .replace('}','')
                                                .split(',')
                            errors.forEach(element => {
                                
                                this.alerta.mensaje += element + ' - '       
                            });
                            this.alerta.tipo = 9;
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
            }
        },
        modificar(){
            let param = this.obj;
            this.load=true
            try {
                axios
                .put(this.page +"/"+ this.user.id, param)
                .then((response) => {
                    this.alerta.mensaje = ''
                    if (response.data.status == 0) {
                        //alerta//
                        this.alerta.mensaje = "Se Modifico correctamente el Usuario.";
                        this.alerta.tipo = 1;
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
                            this.alerta.tipo = 9;
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
        selectZona(z){
            this.obj.zona = z;
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
                .get("home/Camus/Users/combotipo")
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
        listZona(){
            try {
                axios
                .get("home/Camus/Users/combozona")
                .then((response) => {
                    this.itemZona = response.data;
                    
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
                        permisos:{  menu:{"usuario":false,"cliente":false,"producto":false,"reporte":false,"config":false},
                                    cliente:{"nuevo":false,"modificar":false,"eliminar":false,"asociar":false,'modificarasociado':false,"pago":false},
                                    usuario:{"nuevo":false,"modificar":false,"eliminar":false},
                                    producto:{"nuevo":false,"modificar":false,"eliminar":false},
                                    reporte:{"nuevo":false,"modificar":false,"eliminar":false},
                                    config:{"nuevo":false,"modificar":false,"eliminar":false},
                                }, 
                        tipo_id:0,
                        zona_id:0   
            }
        }
        
    },

}
</script>