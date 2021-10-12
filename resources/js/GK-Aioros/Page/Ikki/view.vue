<template>

<v-row justify="center" id="modalMenu" >
    <v-container fluid >
        <v-card v-for="(albun,index) in albunes" :key="index">
            <div style="width: 100%;">
                <v-subheader  >
                    <b>Albun {{albun.titulo}} - [ {{albun.cantidad}} Archivos ]</b>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="mx-2 " 
                        :title="'Abrir'" 
                        fab  
                        outlined 
                        x-small 
                        :color="'cyan'"
                        @click="cerrarModal"
                    >
                        <v-icon dark> mdi-close </v-icon>
                        
                    </v-btn>
                </v-subheader>
            </div>
            <div class="row">
                <v-col class="d-flex child-flex" cols="4">
                    <v-img
                        :src="'galeria' "
                        :lazy-src="'galeria' "
                        aspect-ratio="1"
                        class="grey lighten-2"
                    >
                        
                        <v-row
                            class="fill-height ma-0"
                            align="center"
                            justify="center"
                        >
                            <abm :tipo="'Nuevo'" :albun="albun.id"></abm>
                        </v-row>
                        
                    </v-img>
                </v-col>
                <v-col v-for="n in albun.galeria" :key="n" class="d-flex child-flex" cols="4" >
                <v-img
                    :src="'galeria/' + n.nombre"
                    :lazy-src="'galeria/' + n.nombre"
                    aspect-ratio="1"
                    class="grey lighten-2"
                >
                    <template v-slot:placeholder>
                    <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                    >
                        <v-progress-circular
                            indeterminate
                            color="grey lighten-5"
                        ></v-progress-circular>
                    </v-row>
                    </template>
                </v-img>
                </v-col>
            </div>
        </v-card>
    </v-container>

</v-row>
</template>
<script>
import abm from './fileup.vue'
export default {
    props:['idAlbun'],
    data() {
        return {
            albunes:[],
            page:'home/Ikki/Albun/data',

        }
    },   
    components:{
        abm
    },
    watch: {
        idAlbun(){
            this.index()
        }
        
    },
    created() {
        this.index()
    },
    methods: {
        index(){
             try {
               
                axios.get(this.page+'/'+this.idAlbun)
                    .then((response) => {
                        console.log('albunes')
                        console.log(response.data.data.data)
                        this.albunes = response.data.data.data
                    })
                    .catch((error) => {
                    
                    
                    })
                    .finally(() => false);
            } catch (error) {
                console.log(error);
            }
        },
        cerrarModal(){
            this.idAlbun = 0
            this.$emit('RefresModal',true)
        }
    },
}
</script>