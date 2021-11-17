<template>
    <div>
        <v-row>
            <v-col cols="12" md='10'>
                {{title}}
            </v-col>
            <v-col cols="12" md='2'>
                Agregar
                <SPT :tipo="'Nuevo'" @SelectSTP="SelectSTP"/>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md='12'>
            
                <vuetable ref="vuetable"
                        :fields="fields"
                        :api-mode="false"
                        :data="arraySPT"
                        :show-sort-icons="false"
                        :css="css.table"
                        pagination-path=""
                        id="mytabla"> 
                            <template slot="action" slot-scope="props">
                                <div>
                                    <v-btn
                                        class="mx-2 " 
                                        fab  
                                        outlined 
                                        x-small 
                                        :color="'red'"
                                        @click="eliminar(props.rowData)"
                                        >
                                            <v-icon dark outlined> mdi-delete </v-icon>
                                    </v-btn>
                                </div>
                            </template>       
                </vuetable>
            </v-col>
        </v-row>
    </div>
    
</template>
<script>
import CssVuetable from '../../../../StyleDataTable/DataTable_Nr';
import SPT from './SPT.vue'
export default {
    props:['object','title'],
    data() {
        return {
            css:CssVuetable,
            arraySPT:[],
            arraySPTindex:[],
            fields:[{
                name:'action',
                title:'#',
                titleClass: 'center aligned',
              },{
                name:'sector.nombre',
                title:'Sector',
                titleClass: 'center aligned',
              },{
                name:'puesto.nombre',
                title:'Puesto',
                titleClass: 'center aligned',
              },{
                name:'tarea.nombre',
                title:'Tarea',
                titleClass: 'center aligned',
              },
            ]
        }
    },
    components:{
        CssVuetable,
        SPT
    },
    methods: {
      SelectSTP(s){
            let i = this.arraySPTindex.indexOf(String(s.sector.id)+String(s.puesto.id)+String(s.tarea.id))
            if(i < 0){
                this.arraySPTindex.push(String(s.sector.id) + String(s.puesto.id) + String(s.tarea.id))
                let STP={   sector:{id:s.sector.id,nombre:s.sector.nombre},
                            puesto:{id:s.puesto.id,nombre:s.puesto.nombre},
                            tarea:{id:s.tarea.id,nombre:s.tarea.nombre}
                        }
                this.arraySPT.push(STP)
               
                this.$emit('resultado',this.arraySPT)
            }
            
      },
      eliminar(e){
            let i = this.arraySPTindex.indexOf(String(e.sector.id)+String(e.puesto.id)+String(e.tarea.id))
            this.arraySPTindex.splice(i,1);
            this.arraySPT.splice(i,1);
            this.$emit('resultado',this.arraySPT) 
      }
    },
    
}
</script>