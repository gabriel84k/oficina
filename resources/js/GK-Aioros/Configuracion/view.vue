<template>
    <v-row justify="center " id="modalMenu" >
        <v-container fluid >
            <v-card>
                <v-toolbar class="sau-dataTable__title white--text" dark>
                    <v-btn icon dark @click="closeModal">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Configuraciones </v-toolbar-title>
                    <v-spacer></v-spacer>
                
                </v-toolbar>
                <v-list three-line subheader>
                    <v-list-item>
                        <v-list-item-content>
                            <v-tabs>
                                <v-tab>
                                    Productos Asociados
                                </v-tab>
                                <v-tab>Otros</v-tab>
                                <v-tab>Mas++</v-tab>
                                
                                <v-tab-item>
                                    <br />
                                    <sistema></sistema>
                                     <br />
                                </v-tab-item>
                                <v-tab-item>
                                    Falta Completar
                                </v-tab-item>
                                <v-tab-item>
                                Falta Completar
                                </v-tab-item>
                            </v-tabs>
                                    
                            <!---->
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-container>
    </v-row>
   
</template>
<script>
import sistema from '../Page/Aldebaran/Sistemas/view'
export default {
    props:['permiso'],
    data() {
        return {
            permisos:[]
        }
    },
    
    created(){
       
    },
    components:{
        sistema
    },
    methods: {
      closeModal(){
          this.$store.commit('showComponent', {title: 'Tablero', icon: '', modal:'Tablero',permiso:'' })
      }
    },
}
</script>