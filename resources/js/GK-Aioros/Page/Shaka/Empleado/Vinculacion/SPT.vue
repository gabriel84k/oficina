<template>
    <v-dialog v-model="dialog" width="100%" persistent>
        <template v-slot:activator="{ on, attrs }" >
            <v-btn
            class="mx-2 " 
            :title="tipo" 
            fab  
            outlined 
            x-small 
            v-bind="attrs"
            v-on="on"
            :color="(tipo == 'Nuevo')?'green':'cyan'"
            >
                <v-icon v-if="(tipo == 'Modificando')" dark outlined> mdi-pencil </v-icon>
                <v-icon v-else outlined>mdi-plus</v-icon>
            
            </v-btn>
                
        </template>

        <v-card>
            <v-card-title class="blue lighten-1 text-white"> Vinculación de Sector - Puesto - Tarea </v-card-title>

            <v-card-text>
                <template>
                    <div>
                        <br>
                        <v-row>
                            
                            <v-col cols="4"> 
                                <div v-for="(item,index) in red[0].sector" :key="index">
                                    <v-card
                                        elevation="24"
                                        max-width="444"
                                        width="310"
                                        class="mx-auto"
                                        style="cursos:pointer"
                                        @click="selectPuesto(item.puesto,item)"
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
                                </div>
                                <br>
                            </v-col>
                            <v-col cols="4">
                                <Puesto :puesto="puesto" @ResultPT="dataTarea"></Puesto>
                            </v-col>
                            <v-col cols="4">
                                <Tarea :tarea="tarea" @result="selectTarea"></Tarea>
                            </v-col>
                            
                        </v-row>

                    </div>
                </template>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <msjAlerta :msj="alerta"></msjAlerta>
                <v-btn color="primary" text @click="closealert()"> Salir </v-btn>
                <v-btn v-if="(tipo == 'Nuevo')" color="primary" text @click="nuevo()"> Guardar </v-btn>
                <v-btn v-else color="primary" text @click="modificar()"> Modificar </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import CrudSector from '../../crud_Sector.vue'
import CrudPuesto from '../../crud_Puesto.vue'
import CrudTarea from '../../crud_Tarea.vue'
import Puesto from '../../Puesto.vue'
import Tarea from '../../Tarea.vue'
export default {
    props:['tipo'],
    data() {
        return {
            cyrcle:true,
            alerta: { mensaje: "", visible: false, tipo: 0 },
            load:false,
            valid:true,
            dialog:false,
            red:[],
            spt:{   sector:{id:0,nombre:''},
                    puesto:{id:0,nombre:''},
                    tarea:{id:0,nombre:''},                    
                },
            puesto:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Puesto/data',data:[]},
            empleado:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Empleado/data',data:[]},
            tarea:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Tarea/data',data:[]},
            page:'/home/Shaka/Red/Sector/data'
        }
    },
    components:{
        CrudSector,
        CrudPuesto,
        CrudTarea,
        Puesto,
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
        selectPuesto (puesto, Sector){
            console.log('sector',Sector)
            this.spt.sector.id = Sector.id
            this.spt.sector.nombre = Sector.nombre
            if(puesto.length > 0){
                this.puesto.data = puesto
            }else{
                this.puesto.data = []
                this.empleado.data = []
                this.tarea.data = []
            }
        },
        dataTarea(tarea){
            console.log('puesto',tarea[2])
            this.spt.puesto.id = tarea[2].id
            this.spt.puesto.nombre = tarea[2].nombre
            if(tarea[1].length > 0){
                this.tarea.data = tarea[1]
            }else{
                this.tarea.data = []
            }
            
        },
        selectTarea(t){
            console.log('tarea',t)
            this.spt.tarea.id = t.id
            this.spt.tarea.nombre = t.nombre
            this.$emit('SelectSTP',this.spt)
            
        },
        closealert() {
            this.dialog = false;
            this.alerta = { mensaje: "", visible: false, tipo: 0 };
        },
      
    }
}
</script>