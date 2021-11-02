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
                    @click="selectPuesto(item.puesto)"
                >
                    <v-system-bar lights-out></v-system-bar>
                    <v-row >
                        <v-col cols="12" align="center">
                            <CrudSector :sector="sector" :tipo="'Modificando'"></CrudSector>
                        </v-col>
                    </v-row>
                    <v-list two-line>
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
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

        <!-- Puestos -->
        <v-row >
            
            <v-col cols="4" v-for="(itemPuesto,index) in puesto.data" :key="index">
                <v-card
                    v-if="itemPuesto"
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                    style="cursos:pointer"
                    @click="selectTarea(item.puesto)"
                >
                    <v-system-bar lights-out></v-system-bar>
                    <v-row >
                        <v-col cols="12" align="center">
                            <CrudPuesto :puesto="puesto" :tipo="'Modificando'"></CrudPuesto>
                        </v-col>
                    </v-row>
                    <v-list two-line>
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                        <v-list-item-title>{{itemPuesto.nombre}}</v-list-item-title>
                        <v-list-item-subtitle>{{itemPuesto.descripcion}}</v-list-item-subtitle>
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
                            <CrudPuesto :puesto="puesto" :tipo="'Nuevo'"></CrudPuesto>
                        </v-col>
                    </v-row>

                    <v-list two-line>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img src=""></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Nuevo Puesto</v-list-item-title>
                                <v-list-item-subtitle>Crer un nuevo Puesto</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
        <!-- tareas -->
        <v-row v-if="false">
           
            <v-col cols="4" v-for="(index,item) in puesto" :key="index">
                <v-card
                    elevation="24"
                    max-width="444"
                    width="310"
                    class="mx-auto"
                >
                    <v-system-bar lights-out></v-system-bar>

                    <v-list two-line>
                    <v-list-item>
                        <v-list-item-avatar>
                        <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                        <v-list-item-title>{{item.nombre}}</v-list-item-title>
                        <v-list-item-subtitle>{{item.detalle}}</v-list-item-subtitle>
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
                            <v-btn
                                color="primary"
                                elevation="2"
                                icon
                                @click="nuevoPuesto()"
                            >
                            <v-icon dark>
                                mdi-plus
                            </v-icon>
                        </v-btn>
                        </v-col>
                    </v-row>

                    <v-list two-line>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img src=""></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Nuevo Puesto</v-list-item-title>
                                <v-list-item-subtitle>Crer un nuevo Puesto</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>

        
    </div>
</template>
<script>
import CrudSector from './crud_Sector.vue'
import CrudPuesto from './crud_Puesto.vue'
export default {
    props:[],
    data() {
        return {
            cyrcle:true,
            red:[],
            sector:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Sector/data'},
            puesto:{visible:false, tipo:'Nuevo', page:'/home/Shaka/Red/Puesto/data',data:[]},
            page:'/home/Shaka/Red/Sector/data'

        }
    },
    components:{
        CrudSector,
        CrudPuesto
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
        selectPuesto (puesto){
            this.puesto.data = puesto
        }
    },
}
</script>