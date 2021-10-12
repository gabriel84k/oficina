<template>
    <div>
       
        <v-row align="center col">
            
            <v-item-group
                v-model="window"
                class="shrink mr-6"
                mandatory
                tag="v-flex"
            >
            <v-item v-for="(p,i) in permiso"  :key="i" v-slot="{ active, toggle }">
                <div>
                    <v-btn 
                        :input-value="active" 
                        icon 
                        @click="toggle"
                    >
                        {{i}}
                    </v-btn>
                </div>
            </v-item>
            </v-item-group>

            <v-col>
                <v-window v-model="window" class="elevation-1" vertical >
                    <v-window-item v-for="(p,i) in permiso" :key="i">
                        <v-card flat>
                            <v-card-text>
                                <v-row class="mb-4" align="center">
                                    <v-avatar color="grey" class="mr-4"></v-avatar>
                                    <strong class="title">{{ i }}</strong>
                                    <v-spacer></v-spacer>
                                    <v-btn icon>
                                    <v-icon>mdi-account</v-icon>
                                    </v-btn>
                                </v-row>
                                <v-card-text>
                                    <v-col cols="12" md="4" v-for="(item,index) in p" :key="index" >
                                        <v-checkbox
                                            v-model="objPermiso[i][index]"
                                            :label="index"
                                            color="success"
                                            :value="item"
                                            hide-details
                                            @change="refresh()"
                                        >
                                        </v-checkbox>
                                    </v-col>
                                </v-card-text>
                            </v-card-text>
                        </v-card>
                    </v-window-item>
                </v-window>
            </v-col>
        </v-row>
        <!--
        <v-col cols="12" md="12">
            <div>
                <v-row>
                    <v-col cols="12" md="2" class="border">
                        <h4 class="red--text">Menus</h4>
                        <hr>
                        
                        
                        <v-checkbox
                            v-model="permiso.menu.ticket"
                            label="Deposito"
                            color="success"
                            :value="permiso.menu.ticket"
                            hide-details
                        >
                        </v-checkbox>
                        <v-checkbox
                            v-model="permiso.menu.usuario"
                            label="Maletín"
                            color="success"
                            :value="permiso.menu.usuario"
                            hide-details
                        >
                        </v-checkbox>
                       
                    </v-col>
                    
                    <v-col cols="12" md="8">
                        <h4 class="red--text">General</h4>
                        <hr>
                        <v-row>
                            
                            <v-checkbox
                                v-model="permiso.ticket.nuevo"
                                label="Nuevo"
                                color="success"
                                :value="permiso.ticket.nuevo"
                                hide-details
                            ></v-checkbox>
                            <v-checkbox
                                v-model="permiso.ticket.modificar"
                                label="Modificación"
                                color="success"
                                :value="permiso.ticket.modificar"
                                hide-details
                            ></v-checkbox>
                            <v-checkbox
                                v-model="permiso.ticket.eliminar"
                                label="Eliminación"
                                color="success"
                                :value="permiso.ticket.eliminar"
                                hide-details
                            ></v-checkbox>
                            <v-checkbox
                                v-model="permiso.usuario.nuevo"
                                label="Nuevo"
                                color="success"
                                :value="permiso.cliente.nuevo"
                                hide-details
                            ></v-checkbox>
                            <v-checkbox
                                v-model="permiso.cliente.modificar"
                                label="Modificar"
                                color="success"
                                :value="permiso.cliente.modificar"
                                hide-details
                            ></v-checkbox>
                            <v-checkbox
                                v-model="permiso.cliente.eliminar"
                                label="Eliminar"
                                color="success"
                                :value="permiso.cliente.eliminar"
                                hide-details
                            ></v-checkbox>
                        </v-row>
                       
                    </v-col>
                    
                </v-row>
            </div>
           
        </v-col> -->
    </div>
</template>
<script>

export default {
    props:['permisos'],
    data() {
        return {
            window: 0,
            objPermiso:[],
            permiso:{  
                menu:{"ticket":false,"usuario":false,"conf.":false,"cliente":false,"calendario":false,"ctacte":false,"presupuesto":false,"nota":false,"galeria":false},
                ticket:{"nuevo":false,"modificar":false,"eliminar":false,"asociar":false,'modificarasociado':false,"pago":false},
                cliente:{"nuevo":false,"modificar":false,"eliminar":false},
                usuario:{"nuevo":false,"modificar":false,"eliminar":false},
                config:{"sistema":false},
                sistema:{"nuevo":false,"modificar":false,"eliminar":false},
            }, 
        }
    },
   
    mounted() {
        console.log('vue permisos')
        console.log(this.permisos)
        delete(this.permisos.id)
        this.objPermiso = funciones.json_Array(this.permisos)
       
    },
    methods: {
        refresh(){
            
            this.$store.commit('setPermiso', funciones.Array_json(this.objPermiso));
           
        }
    },

}
</script>