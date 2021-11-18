<template>
    <div v-if="tarea.data">
        
        <v-list two-line v-for="(itemTarea,index) in tarea.data" :key="index">
            <v-list-item  @click="selectTarea(itemTarea.id)" style="cursos:pointer">
                <v-list-item-avatar>
                    
                     <v-icon outlined>mdi-check-network</v-icon>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>{{itemTarea.nombre}}</v-list-item-title>
                    <v-list-item-subtitle>{{itemTarea.descripcion}}</v-list-item-subtitle>

                </v-list-item-content>
                <v-list-item-content>
                    <v-list-item-title>
                        <v-col cols="12" align="center">
                            <CrudTarea :tarea="tarea" :tipo="'Modificando'"></CrudTarea>
                        </v-col>
                    </v-list-item-title>
                </v-list-item-content>
                
            </v-list-item>
        </v-list>
    </div>
</template>
<script>
import CrudTarea from './crud_Tarea.vue'
export default {
    name: 'Tarea',
    props:['tarea'],
    data() {
        return {
            
        }
    },
    watch:{
        tarea(p){
           
        }
    },
    mounted(){
       
    },
    components:{CrudTarea},
    methods: {
        
        selectTarea(idTarea){
            axios.get(this.tarea.page+'/'+idTarea)
                .then((response) => {
                    this.$emit('result',response.data.data)
                }).catch((error) => {
                
                })
                .finally(() => false);
        }
    },    
}
</script>