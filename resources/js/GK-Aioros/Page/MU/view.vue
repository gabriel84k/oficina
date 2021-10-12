<template  >
    <v-row justify="center" id="modalMenu" >
        <v-container fluid >
            <v-card>
                <v-toolbar class="sau-dataTable__title white--text" dark>
                    <v-btn icon dark @click="closeModal">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Presupuestos </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- aqui va el abm de presupuesto -->
                    <nuevo v-if="true" :presupuesto="{}" :tipo="'Nuevo'" @refresh="toUpdate" :empresa="empresa"></nuevo>
                </v-toolbar>
                <v-list three-line subheader>
                    <br />
                    <v-subheader  >
                    [botones de filtrado]
                        
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
                                            <nuevo v-if="true" :tipo="'Modificando'" ::presupuesto="props.rowData"  @refresh="toUpdate" :empresa="empresa"  :isrt="isroot"></nuevo>
                                           
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

import CssVuetable from '../../StyleDataTable/DataTable_Nr';
import nuevo from './nuevo';

export default {
    name: "Presupuesto",
    props: ['show','tipo','permiso','user','empresa'],
    data() {
        return { 
            dialog: this.show,
            notifications: false,
            filter: {
                page: "home/MU/Presupuesto/util/filtrado",
                msj: "",
                id:0
            },
            isroot:0,
            sound: true,
            widgets: false,
            object: [],
            presupuesto:[],
            istipo:{tipo:this.tipo},
            css:CssVuetable,
            page:'/home/MU/Presupuesto/data',
            fields:[{
                    name:'id',
                    title:'#',
                    titleClass: 'center aligned',
                    visible:true,
                },{
                    name:'cliente.nombre',
                    title:'Cliente',
                    titleClass: 'center aligned',
                    visible:true,
                        
                },{
                    name:'titulo',
                    title:'Título',
                    titleClass: 'center aligned',
                    visible:true,
                        
                },{
                    name:'total',
                    title:'Total',
                    visible:true,
                    
                },{
                    name:'fecha',
                    title:'Fecha',
                    visible:true,
                    
                },{
                    name:'accion',
                    title:'',
                    visible:true,
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
            this.presupuesto = obj
        },
        deleting:function(obj){
            try { 
                
                axios.delete('/home/MU/Presupuesto/data/'+obj.rowData.id)
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
                    this.presupuesto = this.presupuesto 
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