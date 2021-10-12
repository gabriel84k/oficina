<template>
    <div class="row " outlined>
        <v-col cols="12" md="4">
            <v-text-field
                v-model="cliente.nombre"
                label="Nombre"
                
            ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
            <v-text-field
                v-model="cliente.detalle"
                label="Detalle"
                
            ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">    
            <v-text-field
                v-model="cliente.provincia"
                label="Provincia"
                
            ></v-text-field>
        </v-col>
        
        <v-col cols="12" md="4">
            <v-text-field
                v-model="cliente.telefono"
                label="Telefono"
                
            ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
            <v-text-field
                v-model="cliente.celular"
                label="Celular"
                
            ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
            <v-text-field
                v-model="cliente.nota"
                label="Observaciones"
                
            ></v-text-field>
        </v-col>
    </div>
</template>
<script>
export default {
    props:['cliente'],
    data() {
        return {
            
            obj:{
                nombre:'', 
                detalle:'', 
                provincia:'', 
                nota:0, 
                telefono:0, 
                celular:0, 
                nota:'',
            }
        }
    },
    watch:{
        cliente(cli){
            
            if (cli){
               this.obj = cli 
            }
        }
    }
}
</script>