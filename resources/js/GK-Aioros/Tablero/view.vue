<template>
<div>
    <div class="row">
        <div v-for="i in 4" :key="i" class="col-lg-3 col-sm-12">
            <tajeta :dato="card"></tajeta>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <gracifo
                    :chartData="graficos.barra.datos" 
                    :options="graficos.barra.chartoption" 
                    :tipo="graficos.barra.type" 
                    :ref="graficos.barra.ref">
            </gracifo>
        </div>
        <div class="col-lg-6 col-sm-12">
            <gracifo
                    :chartData="graficos.linea.datos" 
                    :options="graficos.linea.chartoption" 
                    :tipo="graficos.linea.type" 
                    :ref="graficos.linea.ref">
            </gracifo>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <tabla  :fields="tablas.pacientes.field" 
                    :object="tablas.pacientes.objeto" 
                    :ref="tablas.pacientes.ref">
            </tabla>
        </div>
        <div class="col-lg-6 col-sm-12">
        </div>
    </div>

</div>
</template>
<script>
import tajeta from './card'
import tabla from './tabla'
import gracifo from './grafico'
export default {
    data() {
        return {
            graficos:{
                torta:{
                    datos:{
                        labels: ['Emprade','Geas','Distr.'],
                        datasets: [
                            {
                                label: 'Totales por Comercializadora',
                                backgroundColor: ['#ff0000c9','#14ff00','#0080ff'] ,
                                data:  [4059,5467,456] ,
                            },
                        ]
                    },
                    chartoption:{
                        id:'Chart1',
                        responsive:true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                },
                                scaleLabel: {
                                    display: false
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                // This more specific font property overrides the global property
                                fontColor: '#122C4B',
                                fontFamily: "'Muli', sans-serif",
                                padding: 25,
                                boxWidth: 25,
                                fontSize: 14,
                            },
                            showTooltips: false,
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 0,
                                bottom: 10
                            }
                        },
                        canva:{
                            height:200,
                            width:0

                        },
                        showAllTooltips: false
                    },
                    type:'pie',
                    labels: ['Emprade','Geas','Dist'],
                    ref:'torta' 
                },
                linea:{
                    datos:{
                        labels: ['Emprade','Geas','Distr.'],
                        datasets: [
                            {
                                label: 'Totales por Comercializadora',
                                backgroundColor: ['#ff0000c9','#14ff00','#0080ff'] ,
                                data:  [4059,5467,456] ,
                                borderColor: '#191c20bf' ,
                                fill: false,
                            },
                        ]
                    },
                    chartoption:{
                        id:'Chart2',
                        responsive:true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: false,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                },
                                scaleLabel: {
                                    display: false
                                },
                                gridLines: {
                                    display: true,
                                    drawBorder: false
                                },
                                
                            }]
                        },
                        legend: {
                            labels: {
                                // This more specific font property overrides the global property
                                fontColor: '#122C4B',
                                fontFamily: "'Muli', sans-serif",
                                padding: 25,
                                boxWidth: 25,
                                fontSize: 14,
                            },
                            position: 'top',
                            showTooltips: false,
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 0,
                                bottom: 10
                            }
                        },
                        canva:{
                            height:200,
                            width:0
                        },
                        showAllTooltips: false
                    },
                    type:'line',
                    labels: ['Emprade','Geas','Dist'], 
                    ref:'linea'
                },
                barra:{
                    datos:{
                        labels: ['Emprade','Geas','Distr.'],
                        datasets: [
                            {
                                label: 'Totales por Comercializadora',
                                backgroundColor: ['#3b86ff5e','#ff3b3b5e','#9dff3b5e'] ,
                                data:  [4059,5467,456] ,
                            },
                        ]
                    },
                    chartoption:{
                        id:'Chart1',
                        responsive:true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {if (value % 1 === 0) {return value;}}
                                },
                                scaleLabel: {
                                    display: false
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                // This more specific font property overrides the global property
                                fontColor: '#122C4B',
                                fontFamily: "'Muli', sans-serif",
                                padding: 25,
                                boxWidth: 25,
                                fontSize: 14,
                            },
                            showTooltips: false,
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 0,
                                bottom: 10
                            }
                        },
                        canva:{
                            height:200,
                            width:0

                        },
                        showAllTooltips: false
                    },
                    type:'bar',
                    labels: ['Emprade','Geas','Dist'],
                    ref:'barra' 
                },
            },
            card:{
                titulo:'paciente',
                cantidad:10,
                porc:{visible:true,
                      value:'100'
                },


            },
            tablas:{
                pacientes:{
                    titulo:'top 5 pacientes',
                    field:[
                        {
                            name: "apellidoNombre",
                            title: "Nombre y Apellido",
                            visible: true,
                        },{
                            name: "dni",
                            title: "Dni",
                            visible: true,
                        },{
                            name: "direccion",
                            title: "Direccion",
                            visible: true,
                        },{
                            name: "estado",
                            title: "Estado",
                            visible: true,
                            formatter(val){
                                return  (val == 1)?'Activo':'Inactivo'
                            }
                        }
                    ],
                    objeto:[],
                    ref:'vuetable'
                }
            }
        }
    },
    components:{
        tajeta,
        tabla,
        gracifo
    },
    mounted() {
        this.index()
    },
    methods: {
        index(){
            /* Aquí agregar la lectura de los datos */
             this.$refs.load.load('toupdate')
        }
    },
}
</script>