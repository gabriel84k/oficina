<template  >
    <v-row justify="center" id="modalMenu" >
        <v-container fluid >
            <v-card>
                <v-toolbar class="sau-dataTable__title white--text" dark>
                    <v-btn icon dark @click="closeModal">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Clientes </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- aqui va el abm de usuarios -->
                    
                    <nuevo v-if="true" :user="{}" :tipo="'Nuevo'" @refresh="toUpdate" :view="viewUserCliente"></nuevo>
                </v-toolbar>
                <v-list three-line subheader>
                    <br />
                    <v-subheader  >
                    Listado de Clientes
                        
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
                                    <template slot="accion" slot-scope="props">
                                        
                                        <div class="row text-center" >
                                            <nuevo v-if="true" :tipo="'Modificando'" :user="props.rowData" :view="viewUserCliente" @refresh="toUpdate" ></nuevo>
                                            <v-btn
                                                v-if="true"
                                                class="mx-2" 
                                                fab  
                                                outlined 
                                                x-small 
                                                :color="'red'"
                                                :view="viewUserCliente"
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
import nuevo from '../../../Usuario/nuevo';

export default {
    name: "Cliente",
    props: ['show','tipo','permiso'],
    data() {
        return { 
            dialog: this.show,
            notifications: false,
            viewUserCliente:{option:{ViewCliente:true}},
            filter: {
                page: "home/Aldebaran/util/Cliente/filtrado",
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
            page:'/home/Aldebaran/Cliente/data',
            fields:[{
                    name:'cliente.id',
                    title:'#',
                    titleClass: 'center aligned',
                },{
                    name:'name',
                    title:'Nombre de Usuario',
                    titleClass: 'center aligned',
                        
                },{
                    name:'cliente.nombre',
                    title:'Nombre',
                    titleClass: 'center aligned',
                        
                },{
                    name:'cliente.detalle',
                    title:'Detalle',
                    visible:true,
                    
                },{
                    name:'cliente.provincia',
                    title:'Provincia',
                   
                },{
                    name:'cliente.telefono',
                    title:'Teléfono',
                   
                },{
                    name:'cliente.celular',
                    title:'Celular',
                   
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
        nuevo
    },
    mounted() {
        this.index()
    },
    methods: {
        index:function(){
            try {
                axios
                .get(this.page,this.istipo)
                .then((response) => {
                    if (response.data.status == 0) {
                    this.object = response.data.data;
                    this.isroot = response.data.isroot
                    console.log('lo que trae: '+ this.isroot)
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
                
                axios.delete('/home/Aldebaran/Users/data/'+obj.rowData.id)
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
        toUpdate:function(r){
            switch (r) {
                case 'cliente':
                    this.index()
                    this.cliente = this.cliente 
                break;
            }
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
