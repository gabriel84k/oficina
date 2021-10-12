<template>
     <v-list three-line subheader>
                    <br />
                    <v-subheader  >
                        Logs del sistema
                        
                        <v-spacer></v-spacer>
                        <compBusqueda :param="filter" @objeto="filtrado" :fecha=1 ></compBusqueda>
                        
                    </v-subheader>
                    <v-list-item>
                        <v-list-item-content>
                            <vuetable ref="vuetable"
                                    :fields="fields"
                                    :api-mode="false"
                                    :data="object"
                                    :show-sort-icons="false"
                                    :css="css.table"
                                    pagination-path=""
                                    id="mytabla"
                                    style="overflow-x:auto"> 
                                    
                            </vuetable>
                            <br>
                            <pagination ref="pagination"
                                        :vuepableid="'mytabla'"
                                        :data="object"
                                        @click="pagination"
                            >
                            </pagination>
                                    
                            <!---->
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
</template>
<script>

export default {

    data() {
        return {
            
            page:'home/Camus/log/data',
            object:[],
            filter: {
                page: "home/Camus/util/Log/filtrado",
                msj: "",
                fdesde:'',
                fhasta:'',
                id:0
            },
            css:CssVuetable,
            
            fields:[{
                    name:'id',
                    title:'#',
                    titleClass: 'center aligned',
                },{
                    name:'detalle',
                    title:'Detalle',
                    titleClass: 'center aligned',
                    width:20
                        
                },{
                    name:'tipo',
                    title:'Tipo',
                    visible:true,
                    
                },{
                    name:'created_at',
                    title:'Fecha',
                    formatter: (value) => this.formatDate(value)
                   
                },{
                    name:'usuario.name',
                    title:'Usuario',
                    
                }],
        }
    },
    computed:{
        fdesde(){
            let hoy = new Date();
            let DIA_EN_MILISEGUNDOS = 24 * 60 * 60 * 1000;
            let ayer = new Date(hoy.getTime() - DIA_EN_MILISEGUNDOS);
            ayer = ayer.toISOString().split('T')
            console.log(ayer[0])
            return ayer[0]//ayer.toLocaleDateString();
        },
        fhasta(){
            let hoy = new Date();
            hoy = new Date(hoy.getTime());
            hoy = hoy.toISOString().split('T')
            return hoy[0];
        }
    },
    created() {
        this.filter.fdesde = this.fdesde
        this.filter.fhasta = this.fhasta
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
       
        pagination(url, tableid){
            this.page = url + "&msj="+ this.filter.msj + "&id=undefined&fdesde="+ this.filter.fdesde +"&fhasta="+this.filter.fhasta;
            //this.page = url+"&msj=&id=undefined&fdesde=2021-04-11&fhasta=2021-05-12"
            console.log(this.page)
            this.index();
        },
        filtrado(u) {
            this.object = u;
        },
        formatDate(d){
            console.log(d)
            var fecha = d.split('-')
            return fecha[2].substring(0, 2)+'/'+fecha[1]+'/'+fecha[0]
        }
    },
}
</script>