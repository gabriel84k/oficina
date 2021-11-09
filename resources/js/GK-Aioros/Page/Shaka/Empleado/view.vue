<template  >
    <v-row justify="center" id="modalMenu" >
        <v-container fluid >
            <v-card>
                <v-toolbar class="sau-dataTable__title white--text" dark>
                    <v-btn icon dark @click="closeModal">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Personal {{permiso.personal}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- aqui va el abm de Personal -->
                    <CrudEmpleado v-if="permiso.nuevo" :empleado="object" :tipo="'Nuevo'"></CrudEmpleado>
                </v-toolbar>
                <v-list three-line subheader>
                    <br />
                    <v-subheader  >
                        Listado de Personal
                        
                        <v-spacer></v-spacer>
                        <compBusqueda :param="filter" @objeto="filtrado" ></compBusqueda>
                    </v-subheader>
                    <v-list-item>
                        <v-list-item-content>
                            <vuetable ref="vuetable"
                                    :fields="fields"
                                    :api-mode="false"
                                    :data="object"
                                    :show-sort-icons="false"
                                    :css="css.table"
                                    pagination-path=""
                                    id="mytabla"> 
                                    <template slot="id" slot-scope="props">
                                        <v-avatar>
                                            <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John">
                                        </v-avatar>
                                    </template>
                                    <template slot="accion" slot-scope="props">
                                        
                                        <div class="row text-center" >
                                            <CrudEmpleado :empleado="props.Rowdata" v-if="permiso.modificar" :tipo="'Modificando'"></CrudEmpleado>
                                            <v-btn
                                                v-if="true"
                                                class="mx-2" 
                                                fab  
                                                outlined 
                                                x-small 
                                                :color="'red'"
                                                >
                                            <v-icon  dark> mdi-delete </v-icon>
                                            </v-btn>
                                        </div>
                                    </template>
                            </vuetable>
                            <br>
                            <pagination ref="pagination"
                                        :vuepableid="'mytabla'"
                                        :data="object"
                                        @click="pagination"
                            >
                            </pagination>
                                    
                            <!---->
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-container>
    </v-row>
</template>

<script>

import CssVuetable from '../../../StyleDataTable/DataTable_Nr';
import CrudEmpleado from './crud_Empleado';

export default {
    name: "Cliente",
    props: ['show','tipo','permiso','view'],
    data() {
        return { 
            dialog: this.show,
            notifications: false,
            filter: {
                page: "home/util/Users/filtrado",
                msj: "",
                id:0
            },
            isroot:0,
            sound: true,
            widgets: false,
            object: [],
            usuario:[],
            istipo:{tipo:this.tipo},
            css:CssVuetable,
            page:'/home/Shaka/Red/Empleado/data',
            fields:[{
                    name:'id',
                    title:'#',
                    titleClass: 'center aligned',
                },{
                    name:'nombreApellido',
                    title:'Apellido y nombre',
                    titleClass: 'center aligned',
                        
                },{
                    name:'dni',
                    title:'DNI',
                    visible:true,
                    
                },{
                    name:'domicilio',
                    title:'Domicilio',
                   
                },{
                    name:'telefono',
                    title:'Teléfono',
                
                },{
                    name:'temporal',
                    title:'Temporal',
                    formatter: (value) => { 
                        return value == 1 ? 'SI' : 'NO'
                    }
                },{
                    name:'estado',
                    title:'Estado',
                    formatter: (value) => { 
                        return value == 1 ? 'Activo' : 'Inactivo'
                    }
                },{
                    name:'accion',
                    title:'',
            }],
        }
    },
    components:{
        CrudEmpleado
    },
    mounted() {
        this.index()
    },
    methods: {
        index:function(){
            try {
                axios
                .get(this.page)
                .then((response) => {
                    if (response.data.status == 0) {
                        this.object = response.data.data;
                    
                    } else {
                        console.log("error");
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
        },
        edit:function(obj){
            this.usuario = obj
        },
        deleting:function(obj){
            try { 
                
                axios.delete('/home/Users/data/'+obj.rowData.id)
                    .then(response => {
                        if (response.data.status=='0'){
                           
                            this.index()
                        }else{
                             
                             console.log('error');
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
        },
        pagination(url, tableid){
            this.page = url;
            this.index();
        },
       
        filtrado(u) {
            this.object = u;
        },
        closeModal: function () {
            
            this.$emit("close", false);
        },
      
    },
    
}

</script>
