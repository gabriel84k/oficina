<template>
    <v-card>
        
        <v-card-text>
                <v-list-item-content>
                    <vuetable
                        ref="vuetablepagos"
                        :fields="fields"
                        :api-mode="false"
                        :data="object"
                        :show-sort-icons="true"
                        pagination-path=""
                        :css="css.table"
                        id="vuetablepagos"
                        class="shadow-lg mb-5 bg-white rounded"
                        
                    >
                        <template slot="accion" slot-scope="props">
                          
                            <v-card-actions> 
                                <editarCtacte v-if="permisopago.editpago" :ctacteDetalle="props.rowData"></editarCtacte>
                                <v-btn
                                    v-if="permisopago.editpago"
                                    class="mx-2 " 
                                    title="Eliminar" 
                                    fab  
                                    outlined 
                                    x-small 
                                    color="red"
                                >
                                    <v-icon  color="red"> mdi-delete </v-icon>
                                </v-btn>
                            </v-card-actions>
                        </template>
                    </vuetable>
                    <pagination ref="pagination" :data="object" @click="pagination">
                    </pagination>
                    <v-row>
                        <v-col cols="12" md="4">

                            <v-btn
                                color="primary"
                                depressed
                                elevation="5"
                                text
                                tile
                            >Imprimir</v-btn>
                        </v-col>
                        <v-col cols="12" md="4"></v-col>
                        <v-col cols="12" md="4">Total: {{TotalGrilla}}</v-col>
                    </v-row>
                </v-list-item-content>
        </v-card-text>
    </v-card>
</template>
<script>
import editarCtacte from './amb/editar'
export default {
    props:['ctacte_id','permisopago'],
    data() {
        return {
            object:[],
            TotalGrilla:0,
            css: CssVuetable,
            page: 'home/Camus/ctacte/data',
            fields:[
             {
                name: "id",
                title: "#",
                visible: true,
             },
             {
                name: "Fecha",
                title: "Fecha",
                visible: true,
                formatter:(value)=> this.formatDate(value)
             },
             {
                name: "Pago",
                title: "Pago",
                visible: true,
                formatter(value) { 
                    return '$'+value
                }
             },
             {
                name: "accion",
                title: "Acción",
                visible: true,
             }

         ]   
        }
    },
    components:{
        editarCtacte
    },
    watch:{
        ctacte_id(id){
            this.object=[],
         
            this.index(this.page+'/'+id)
        }
    }, 
    created() {
        this.index(this.page+'/'+this.ctacte_id)
    },
    methods: {
        index(page){
             try {
                //this.load=true
                axios
                .get(page)
                .then((response) => {
                    if (response.data.status == 0) {
                        
                        this.object = response.data.data.detallepago;
                        this.TotalGrilla = parseFloat(response.data.data.Total) - parseFloat(response.data.data.Resto)
                        
                    } else {
                        console.log("error");
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.load=false
                })
                .finally(() => this.load=false);
            } catch (error) {
                console.log(error);
            }
        },
         pagination(url, tableid) {
            
            this.index(url);
        },
        formatDate(d){
            var fecha = d.split('-')
            return fecha[2]+'/'+fecha[1]+'/'+fecha[0]
        },
    },


}
</script>