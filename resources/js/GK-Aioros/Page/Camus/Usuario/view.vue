<template  >
    <v-row justify="center" >
        <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition">
            <v-card>
                <v-toolbar class="sau-dataTable__title white--text" dark>
                    <v-btn icon dark @click="closeModal">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Usuarios </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- aqui va el abm de usuarios -->
      
                    <nuevo v-if="permiso.nuevo" :user="{}" :tipo="'Nuevo'" @refresh="toUpdate"></nuevo>
                </v-toolbar>
                <v-list three-line subheader>
                    <br />
                    <v-subheader  >
                    Listado de Usuarios
                        
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
                                       
                                        <div class="row text-center" v-if="visibilidad(props.rowData)">
                                            <nuevo v-if="permiso.modificar" :tipo="'Modificando'" :user="props.rowData"  @refresh="toUpdate"  :isrt="isroot"></nuevo>
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
                                    
                            <!---->
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>

import CssVuetable from '../StyleDataTable/DataTable_Nr';
import nuevo from './nuevo';
export default {
    name: "Cliente",
    props: ["show","permiso",'user'],
    data() {
        return { 
            dialog: this.show,
            notifications: false,
            filter: {
                page: "home/Camus/util/Users/filtrado",
                msj: "",
                id:0
            },
            isroot:0,
            sound: true,
            widgets: false,
            object: [],
            usuario:[],
            css:CssVuetable,
            page:'/home/Camus/Users/data',
            fields:[{
                    name:'id',
                    title:'#',
                    titleClass: 'center aligned',
                },{
                    name:'name',
                    title:'Nombre',
                    titleClass: 'center aligned',
                        
                },{
                    name:'email',
                    title:'Email',
                    visible:true,
                    
                },{
                    name:'tipo.nombre',
                    title:'Tipo',
                   
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
        this.permiso = JSON.parse (this.permiso)
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
            this.usuario = obj
            /*
            this.usuarios.user=obj.rowData
            this.usuarios.user.boton=2
            this.usuarios.user.titulo='Editando Usuario...'
        },
        news:function(){
            /*
            this.usuarios.user={}
            this.usuarios.user.id=-1
            this.usuarios.user.boton=1
            this.usuarios.user.titulo='Nuevo Usuario...'
            */
        },
        deleting:function(obj){
            try { 
                
                axios.delete('/home/Camus/Users/data/'+obj.rowData.id)
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
        visibilidad(u){
            if (u.id == this.user.id){
                return true
            }
            if (this.user.tipo_id == 1){
                return true
            }
        }
        

    },
    
}

</script>
