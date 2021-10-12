<template>

<v-row justify="center" id="modalMenu" >
    <v-container fluid v-if="dialog">
            
        <div class="row">
            <v-col class="d-flex child-flex" cols="4">
                <v-img
                    :src="''"
                    :lazy-src="'galeria' "
                    aspect-ratio="1"
                    class="grey lighten-2"
                >
                    
                    <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                    >
                        <nuevoAlbun :tipo="'Nuevo'" @refresh="index"></nuevoAlbun>
                    </v-row>
                    
                </v-img>
            </v-col>
            <v-col v-for="n in albunes" :key="n" class="d-flex child-flex" cols="4" >
            <v-img
                :src="'galeria/'"
                :lazy-src="'galeria/'"
                aspect-ratio="1"
                class="grey lighten-2"
            >
                <v-row
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                >
                   {{n.titulo}}
                    
                    <v-btn
                        class="mx-2 " 
                        :title="'Abrir'" 
                        fab  
                        outlined 
                        x-small 
                        :color="'cyan'"
                        @click="abrirModal(n)"
                    >
                        <v-icon dark> mdi-pencil </v-icon>
                        
                    </v-btn>
                   
                </v-row>
                
            </v-img>
            </v-col>
        </div>
      
    </v-container>
    <component  v-bind:is="modal" :idAlbun="albun" @RefresModal="closeModal"></component>
</v-row>
</template>
<script>
import galeria from './view.vue'
import nuevoAlbun from './nuevoAlbun.vue'
export default {
    
    data() {
        return {
            albunes:[],
            page:'home/Ikki/Albun/data',
            modal:'galeria',
            albun:0,
            dialog: true,
        }
    },   
    components:{
        galeria,
        nuevoAlbun
    },
    created() {
        this.index()
    },
    methods: {
        index(){
             try {
               
                axios.get(this.page)
                    .then((response) => {
                        console.log('albunes')
                        console.log(response.data.data)
                        this.albunes = response.data.data
                    })
                    .catch((error) => {
                    
                    
                    })
                    .finally(() => false);
            } catch (error) {
                console.log(error);
            }
        },
        abrirModal(a){
            console.log(a)
            this.dialog = false
            this.modal = 'galeria'
            this.albun = a.id
        },
        closeModal(val){
            this.dialog = val
            this.modal = ''
        }
    },
}
</script>