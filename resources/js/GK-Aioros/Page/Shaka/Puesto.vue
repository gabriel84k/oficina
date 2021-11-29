<template>
    <div v-if="puesto.data">
        <v-list two-line v-for="(itemPuesto,index) in puesto.data" :key="index">
            <v-list-item  @click="selectEmpleadoTarea(itemPuesto)" style="cursos:pointer">
                <v-list-item-avatar>
                    
                     <v-icon outlined>mdi-tournament</v-icon>
                </v-list-item-avatar>
               
                    <v-list-item-content>
                       
                        <v-list-item-title>{{itemPuesto.nombre}}</v-list-item-title>
                        <v-list-item-subtitle>{{itemPuesto.descripcion}}</v-list-item-subtitle>
                        
                    </v-list-item-content>
                    <v-list-item-content>
                        <v-list-item-title>
                            <v-col cols="12" align="center">
                               <CrudPuesto :puesto="itemPuesto" :tipo="'Modificando'" ></CrudPuesto>
                            </v-col>
                        </v-list-item-title>
                    </v-list-item-content>
            </v-list-item>
        </v-list>
    </div>
</template>
<script>

import CrudPuesto from './crud_Puesto.vue'
export default {
    name: 'Puesto',
    props:['puesto'],
    data() {
        return {
            page:'/home/Shaka/Red/Puesto/data'
        }
    },
    watch:{
        puesto(p){
           
        }
    },
    components:{CrudPuesto},
    
    methods: {
        
        selectEmpleadoTarea(Puesto){
            axios.get(this.page+'/'+Puesto.id)
                .then((response) => {
                    this.$emit('ResultPT',[response.data.data.personal,response.data.data.tarea,{id:Puesto.id,nombre:Puesto.nombre}])
                    
                }).catch((error) => {
                
                })
                .finally(() => false);
        }
    },    
}
</script>