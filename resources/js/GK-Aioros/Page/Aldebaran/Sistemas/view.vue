<template>
    <v-row justify="center" id="modalMenu" >
        <v-card height="100%">
            <v-toolbar class="sau-dataTable__title white--text" dark>
              
                <v-spacer></v-spacer>
              
                Crear Nuevo Producto
                <nuevo  v-if="permiso.nuevo" :sistema="sistema" :tipo="'Nuevo'" @refresh="toUpdate"></nuevo>
            </v-toolbar>
            <v-list three-line subheader>
                <br />
                <v-subheader  >
                Listado de Sistemas Asociados

                    <v-spacer></v-spacer>
                    <compBusqueda :param="filter" @objeto="filtrado" ></compBusqueda>
                </v-subheader>
                <v-list-item>
                    <v-list-item-content>
                        <vuetable ref="vuetable_sistema"
                                :fields="fields"
                                :api-mode="false"
                                :data="object"
                                :show-sort-icons="false"
                                :css="css.table"
                                pagination-path=""
                                id="mytabla"> 
                                <template slot="accion" slot-scope="props">
                                    
                                    <div class="row text-center" >
                                        <nuevo v-if="permiso.modificar" :tipo="'Modificando'" :sistema="props.rowData"  @refresh="toUpdate" ></nuevo>
                                        <v-btn
                                            v-if="permiso.eliminar"
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
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-card>
    </v-row>

</template>
<script>

import CssVuetable from '../../../StyleDataTable/DataTable_Nr';
import nuevo from './nuevo';

export default {
    name: "producto_sistemas",
    props: [],
    data() {
        return { 
            dialog: this.show,
            notifications: false,
            filter: {
                page: "home/util/Sistema/filtrado",
                msj: "",
                id:0
            },
            isroot:0,
            permiso:[],
            object: [],
            sistema:[],
            istipo:{tipo:this.tipo},
            css:CssVuetable,
            page:'/home/Aldebaran/Sistema/data',
            fields:[{
                    name:'id',
                    title:'#',
                    titleClass: 'center aligned',
                },{
                    name:'nombre',
                    title:'Nombre',
                    titleClass: 'center aligned',
                        
                },{
                    name:'empresa',
                    title:'Empresa',
                    titleClass: 'center aligned',
                        
                },{
                    name:'nota',
                    title:'Nota',
                    titleClass: 'center aligned',
                        
                },{
                    name:'created_at',
                    title:'Fecha Creación',
                    visible:true,
                    formatter:(val) => formatfecha.formatEN_ES_TiME(val)
                },{
                    name:'accion',
                    title:'',
            }],
        }
    },
    
    components:{
        nuevo
    },
    computed: {
        getPermiso(){
                
            return this.$store.state.a.permiso
        }
    },
    mounted() {
        this.permiso = JSON.parse(this.getPermiso.sistema)
        this.index()
    },
    methods: {
        index:function(){
            try {
                axios
                .get(this.page)
                .then((response) => {
                    if (response.data.status == 0) {
                        this.object = response.data.data.data;
                        
                    } else {
                    
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
            this.sistema = obj
        },
        deleting:function(obj){
            try { 
                
                axios.delete('/home/Aldebaran/Sistema/data/'+obj.rowData.id)
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
                case 'sistema':
                    this.index()
                    this.cliente = this.cliente 
                break;
            }
        },
        filtrado(u) {
            this.object = u;
        },
        closeModal(){
            this.dialog=false
        }
      
    },
}
</script>