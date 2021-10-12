<template  >
    <v-row justify="center" id="modalMenu" >
        <v-container fluid >
            <v-card>
                <v-list three-line subheader>
                    <br />
                    <v-subheader  >
                        [botones de filtrado]
                        <v-spacer></v-spacer>
                        <compBusqueda :param="filter" @objeto="filtrado" ></compBusqueda>
                    </v-subheader>
                    <v-list-item>
                        <v-list-item-content>
                            <template >
                                <v-card 
                                    v-for="(item, index) in object" :key="index"
                                    class="mx-auto"
                                    max-width="344"
                                    outlined
                                >
                                    <v-list-item three-line>
                                        <v-list-item-content>
                                            <div class="text-overline mb-4">
                                                Prioridad: {{item.estado}} <!-- (importante, ayuda, etc...) -->
                                            </div>
                                            <v-list-item-title class="text-h5 mb-1">
                                                {{item.titulo}}
                                            </v-list-item-title>
                                            <v-list-item-subtitle>{{item.nota.substr(0,39)}}...</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>

                                    <v-card-actions>
                
                                        <crud v-if="true" 
                                            :tipo="'Modificando'" 
                                            :nota="item"  
                                            @refresh="toUpdate" 
                                            :isrt="isroot"></crud>
                                        <v-btn
                                            class="mx-2" 
                                            :title="'Eliminación Nota'"
                                            fab  
                                            outlined 
                                            x-small 
                                            v-bind="attrs"
                                            v-on="on"
                                            @click="deleting(item)"
                                            :color="'red'"
                                        >
                                            
                                            <v-icon >mdi-delete</v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </template>
                                    
                            <!---->
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-container>
    </v-row>
</template>

<script>


import crud from './crud';

export default {
    name: "Nota",
    props: ['show','tipo','permiso','user','empresa'],
    data() {
        return { 
            dialog: this.show,
            notifications: false,
            filter: {
                page: "home/Shura/Nota/util/filtrado",
                msj: "",
                id:0
            },
            isroot:0,
            sound: true,
            widgets: false,
            object: [],
            nota:[],
            istipo:{tipo:this.tipo},
            css:CssVuetable,
            page:'/home/Shura/Nota/data',
          
        }
    },
    components:{
        crud
    },
    mounted() {
        this.index()
    },
    methods: {
        index:function(){
            try {
                axios
                .get(this.page)
                .then((response) => {
                    if (response.data.status == 0) {
                        this.object = response.data.data;
                    
                    } else {
                        console.log("error");
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => console.log(""));
            } catch (error) {
                console.log(error);
            }
        },
        edit:function(obj){
            this.nota = obj
        },
        deleting:function(obj){
            console.log(obj)
            try { 
                axios.delete('/home/Shura/Nota/data/' + obj.id)
                    .then(response => {
                        if (response.data.status=='0'){
                           
                            this.index()
                        }else{
                             
                             console.log('error');
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
                                
            } catch (error) {
                
            }
        },
        filtrado(u) {
            this.object = u;
        },
        toUpdate(){
            this.index()
        }
      
    },
    
}

</script>