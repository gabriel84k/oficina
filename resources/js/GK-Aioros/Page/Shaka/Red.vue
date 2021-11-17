<template>
    <div>
        <!-- Sectores -->
        <v-row>
            
            <v-col cols="4" v-for="(item,index) in red[0].sector" :key="index">
                
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                    style="cursos:pointer"
                    @click="selectPuesto(item.puesto,idSector = item.id)"
                >
                    
                    <v-app-bar  elevation="0" outlined color="white" light>
                        <v-col cols="8"> 
                            {titulo o alguna información}
                        </v-col>
                        <v-col cols="4"> 
                            <CrudSector :sector="sector" :tipo="'Modificando'"></CrudSector>
                        </v-col>
                    </v-app-bar>
                    <v-list two-line>
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-icon outline>mdi-vector-link</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                        <v-list-item-title>{{item.nombre}}</v-list-item-title>
                        <v-list-item-subtitle>{{item.descripcion}}</v-list-item-subtitle>
                        </v-list-item-content>
                        
                    </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
           
            <v-col cols="4">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-row >
                        <v-col cols="12" align="center">
                             <CrudSector :sector="sector" :tipo="'Nuevo'"></CrudSector>
                        </v-col>
                    </v-row>

                    <v-list two-line>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img src=""></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Nuevo Sector</v-list-item-title>
                                <v-list-item-subtitle>Crer un Nuevo Sector</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
           
        </v-row>

       
        <!--Puestos, Empleados y Tareas -->
        <v-row v-if="red[0].sector.length > 0">
           
            <v-col cols="12" >
                <v-card
                    elevation="24"
                    max-width="100%"
                    class="mx-auto"
                >

                    <v-row>
                        <v-col cols="4" >
                            <v-card
                                elevation="24"
                                max-width="100%"
                                class="mx-auto"
                            >
                                <v-app-bar  elevation="1">
                                    <v-col cols="8"> 
                                        <h6>Puestos</h6>
                                    </v-col>
                                    <v-col cols="4"> 
                                        <CrudPuesto :puesto="puesto" :tipo="'Nuevo'" ></CrudPuesto>
                                    </v-col>
                                </v-app-bar>
                               
                                <Puesto :puesto="puesto" @ResultPT="dataEmpleado"></Puesto>
                            </v-card>
                        </v-col>
                       
                        <v-col cols="4" >
                            <v-card
                                elevation="24"
                                max-width="100%"
                                class="mx-auto"
                            >
                            <v-app-bar  elevation="1">
                                <v-col cols="8"> 
                                    Tareas
                                </v-col>
                                <v-col cols="4"> 
                                    <CrudTarea :tarea="tarea" :tipo="'Nuevo'" :idSector="idSector"></CrudTarea>
                                </v-col> 
                            </v-app-bar>
                                <Tarea :tarea="tarea" ></Tarea>
                            
                            </v-card>
                        </v-col>
                         <v-col cols="4" >
                            <v-card
                                elevation="24"
                                max-width="100%"
                                class="mx-auto"
                            >
                                <v-app-bar  elevation="1">
                                    <v-col cols="8"> 
                                         Empleados
                                    </v-col>
                                    <v-col cols="4"> 
                                        <CrudEmpleado :empleado="empleado" :tipo="'Nuevo'"></CrudEmpleado>
                                    </v-col>
                                </v-app-bar>
                               
                                <Empleado :empleado="empleado" @result="dataTarea"></Empleado>
                            
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import CrudSector from './crud_Sector.vue'
import CrudPuesto from './crud_Puesto.vue'
import CrudEmpleado from './Empleado/crud_Empleado.vue'
import CrudTarea from './crud_Tarea.vue'
import Puesto from './Puesto.vue'
import Empleado from './Empleado/Empleado.vue'
import Tarea from './Tarea.vue'

export default {
    name: 'Red',
    props:[],
    data() {
        return {
            cyrcle:true,
            red:[],
            idSector:0,
            sector:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Sector/data'},
            puesto:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Puesto/data',data:[]},
            empleado:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Empleado/data',data:[]},
            tarea:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Tarea/data',data:[]},
            page:'/home/Shaka/Red/Sector/data'

        }
    },
    components:{
        CrudSector,
        CrudPuesto,
        CrudEmpleado,
        CrudTarea,
        Puesto,
        Empleado,
        Tarea
    },
    mounted() {
        this.index()
    },
    methods: {
        index(){

            axios.get(this.page)
                .then((response) => {
                    console.log('Red')
                    console.log(response.data.data)
                    this.red = response.data.data
                }).catch((error) => {
                
                })
                .finally(() => false);
         
        },
        selectPuesto (puesto,idSector){
            
            this.idSector = idSector
            
            if(puesto.length > 0){
                this.puesto.data = puesto
            }else{
                this.puesto.data = []
                this.empleado.data = []
                this.tarea.data = []
            }
            
           
        },
        dataEmpleado(empleado){
            console.log('empleado',empleado)
            if(empleado[0].length > 0){
                this.empleado.data = empleado[0]
            }else{
                this.empleado.data = []
                this.tarea.data = []
            }
            
        },
        dataTarea(tarea){
            this.tarea.data = tarea
        },
       
    },
}
</script>