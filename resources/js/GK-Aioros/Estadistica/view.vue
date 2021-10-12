
<template>
  <div>
    <card></card>
    <v-divider></v-divider>
    <div class="row">
      <div class="col-6">
        <v-chart class="chartTorta theme--light elevation-4" :option="option[0]" />
      </div>
      <div class="col-6">  
        <v-chart class="chartBar theme--light elevation-4" :option="option[1]" />
      </div>
    </div>
  </div>
</template>

<script>
import card from './card.vue'
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { PieChart, BarChart } from "echarts/charts";
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent ,
  
} from "echarts/components";
import VChart, { THEME_KEY } from "vue-echarts";
import { INIT_OPTIONS_KEY } from 'vue-echarts'
import Header from '../Usuario/header.vue';


use([
  CanvasRenderer,
  PieChart,
  BarChart,
  GridComponent,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  
]);

export default {
  name: "HelloWorld",
  components: {
    VChart,
    Header,
    card
  },
  provide: {
    [THEME_KEY]: "dark",
    [INIT_OPTIONS_KEY]: ''
    
  },
  data() {
       
    return {
        chart : [],
        dialog: false,
        page:'/home/estadisticas/',
        option: [{
            title: {
                text: "Título",
                left: "left"
            },
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: "vertical",
                left: "center",
                data: [
                    
                ]
            },
            series: [
            {
                name: "Traffic Sources",
                type: "pie",
                radius: "55%",
                center: ["50%", "50%"],
                data: [
                { value: 335, name: "Direct" },
                { value: 310, name: "Email" },
                { value: 234, name: "Ad Networks" },
                { value: 135, name: "Video Ads" },
                { value: 1548, name: "Search Engines" }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: "rgba(0, 0, 0, 0.5)"
                    }
                }
            }
            ]
        },{
            darkMode:true,
            xAxis: {
                type:'category',
                boundaryGap:true,
                show:true,
                zlevel:0,
                z:0,
                inverse:false,
                
                data: []
            },
            tooltip:{
                show:true,
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                type: 'bar',
                data: []
                }
            ],
            title: {
                text: 'Quarterly Sales Results',
                x: 'center',
                textStyle: {
                    fontSize: 24
                }
            },
            color: ['#127ac2']
        }]
    };
},
 
  methods: {
        closealert() {
            this.dialog = false;
        },
        index(){
            console.log('index')
            this.total()
            this.mas5productos()
        },
        mas5productos(){
            try {
                axios
                .get(this.page+"cincomas")
                .then((response) => {
                    
                    if (response.data.status == 0) {
                        this.option[0].title.text = "Los 5 Productos mas vendidos del Año"
                        this.option[0].legend.data = response.data.legend
                        this.option[0].series[0].data = response.data.result
                        console.log(response.data.name)
                        console.log(response.data.value)
                    } else {
                        console.log("error");
                    }
                })
                .catch((error) => {
                  
                })
                .finally(() => false);
            } catch (error) {
                console.log(error);
            }
        },
        total(){
            
            try {
                axios
                .get(this.page+"totales")
                .then((response) => {
                    
                    if (response.data.status == 0) {
                        this.option[1].title.text = "Totales de Ventas Por Mes"
                        this.option[1].xAxis.data = response.data.name
                        this.option[1].series[0].data = response.data.value
                        console.log(response.data.name)
                        console.log(response.data.value)
                    } else {
                        console.log("error");
                    }
                })
                .catch((error) => {
                  
                })
                .finally(() => false);
            } catch (error) {
                console.log(error);
            }
        }
  },    
};
</script>

<style scoped>
.chartTorta {
  height: 10cm;
  width: 100%;
}
.chartBar {
  height: 10cm;
  width: 100%;
}
</style>