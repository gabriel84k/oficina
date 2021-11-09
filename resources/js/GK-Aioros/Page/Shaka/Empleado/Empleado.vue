<template>
    <div v-if="empleado.data">
       
        <div v-for="(itemEmpleado,index) in  empleado.data" :key="index">
            
            <v-list two-line >
                <v-list-item  @click="selectEmpleado(itemEmpleado.id)" style="cursos:pointer">
                    <v-list-item-avatar>
                        <v-img src="https://cdn.vuetifyjs.com/images/john.png"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>{{itemEmpleado.nombreApellido}}</v-list-item-title>
                        <v-list-item-subtitle>{{itemEmpleado.estado}}</v-list-item-subtitle>

                    </v-list-item-content>
                    <v-list-item-content>
                        <v-list-item-title>
                            <v-col cols="12" align="center">
                                <CrudEmpleado :empleado="empleado" :tipo="'Nuevo'"></CrudEmpleado>
                            </v-col>
                        </v-list-item-title>
                    </v-list-item-content>
                    
                </v-list-item>
            </v-list>
        </div>
    </div>
</template>
<script>

export default {
    props:['empleado'],
    data() {
        return {
          
        }
    },
    watch:{
        empleado(e){
            console.log('empleado',e)
        },
       
    },
    methods: {
        
        selectEmpleado(idEmpleado){
            axios.get(this.empleado.page+'/'+idEmpleado)
                .then((response) => {
                    this.$emit('result',response.data.data.tarea)
                }).catch((error) => {
                
                })
                .finally(() => false);
        }
    },    
}
</script>