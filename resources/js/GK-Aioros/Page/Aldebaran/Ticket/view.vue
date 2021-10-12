<template ref='ticket'>
    <v-row justify="center" id="modalMenu" >
        <v-container fluid>
            <v-card>
                <v-toolbar class="sau-dataTable__title white--text" dark>
                    <v-btn icon dark @click="closeModal">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Ticket  </v-toolbar-title>
                    <v-spacer></v-spacer>
                  
                    <nuevo v-if="this.permiso.nuevo" :ticket="{}" :tipo="'Nuevo'" @refresh="toUpdate"></nuevo>
                </v-toolbar>
                <v-list three-line subheader>
                    <br />
                    <v-subheader >
                        <botonesFiltros :page="filter.pageBotones" :msj="filter.msj" @objeto="filtroBoton"></botonesFiltros>

                        <v-spacer></v-spacer>
                        <compBusqueda :param="filter" @objeto="filtrado" ></compBusqueda>
                    </v-subheader>
                    <v-list-item>
                        <v-list-item-content>
                            <vuetable ref="vuetable"
                                    :fields="fields"
                                    :row-class="fila_estado"
                                    :api-mode="false"
                                    :data="object"
                                    :show-sort-icons="false"
                                    :css="css.table"
                                    pagination-path=""
                                    id="mytabla"> 
                                    <template slot="accion" slot-scope="props">
                                        
                                        <div class="" >
                                            <detalleTicket :ticke="props.rowData" @refresh="index()" :permiso="permiso"></detalleTicket>
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
        </v-container>
    </v-row>

</template>
<script>

import CssVuetable from '../../../StyleDataTable/DataTable_Nr';
import nuevo from './nuevo';
import detalleTicket from './detalle';

export default {
    name: "Ticket",
    props: ['show','tipo','permiso'],
    data() {
        return { 
            dialog: this.show,
            notifications: false,
            
            filter: {
                tipoboton:'',
                page: "/home/Aldebaran/Ticket/util/filtrado",
                pageBotones: "/home/Aldebaran/Ticket/util/filtradoBoton",
                msj: "",
                id:0
            },
            isroot:0,
            object: [],
            ticket:[],
            istipo:{tipo:this.tipo},
            css:CssVuetable,
            page:'/home/Aldebaran/Ticket/data',
           
            fields:[{
                    name:'id',
                    title:'#',
                    titleClass: 'center aligned',
                },{
                    name:'sistema.nombre',
                    title:'Sistema',
                    titleClass: 'center aligned',
                        
                },{
                    // aca se agrega asi provisorio por siemmpre :)
                    name:'nota',
                    title:'Cliente',
                    titleClass: 'center aligned',
                        
                },{
                    name:'detalleticket.0.titulo',
                    title:'Titulo',
                    titleClass: 'center aligned',
                        
                },{
                    name:'created_at',
                    title:'Fecha Creación',
                    visible:true,
                    formatter:(val) => formatfecha.formatEN_ES_TiME(val)
                },{
                    name:'prioridad',
                    title:'Prioridad',
                    formatter:(val)=>  aldebaran.prioridad(val)
                   
                },{
                    name:'estado',
                    title:'Estado',
                    formatter: (value) => aldebaran.estado(value)
                },{
                    name:'accion',
                    title:'',
            }],
        }
    },
    
    components:{
        nuevo,
        detalleTicket
    },
    mounted() {
        this.index()
    },
    methods: {
        fila_estado:function(dataItem,i){
            if (dataItem.estado == 3){
                return 'alert alert-success'
            }else if (dataItem.estado == 4){
                return 'alert alert-secondary'
            }else if (dataItem.estado == 1){
                return 'alert alert-warning'
            }
        },
        index:function(){
            try {
                axios
                .get(this.page,this.istipo)
                .then((response) => {
                    if (response.data.status == 0) {
                        this.object = response.data.data;
                        this.isroot = response.data.isroot
                    
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
            this.ticket = obj
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
            this.page = url + '&msj='+ this.filter.msj+'&tipo='+ this.filter.tipoboton;
            this.index();
        },
        toUpdate:function(r){
            switch (r) {
                case 'ticket':
                    this.index()
                    this.cliente = this.cliente 
                break;
            }
        },
        filtroBoton(b,tipo){
            console.log(tipo)
            this.filter.tipoboton = b[1];
            this.object = b[0];
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