<template>
  
    <canvas :id="options.id" class="rounded shadow" :height="options.canva.height" :width="options.canva.width"></canvas>
</template>

<script>
import Chart from 'chart.js'
export default {
   props: [
        'tipo',
        'chartData',
        'options'
    ],
    data() {
        return {
            chart : [],
            ctx : '',
            datachart : this.chartData,
            datatipo: '',
            dataoption:[]
        }
    },
  
    mounted() {
           
            this.ctx = document.getElementById(this.options.id).getContext('2d')
            this.datachart = this.chartData
            this.datatipo = this.tipo
            this.dataoption = this.options
            this.load('mounted')
    },
    methods:{
        load (l) {
            console.log(this.datachart)
            
            this.chart = new Chart(this.ctx, {
                    type: this.datatipo,
                    data: this.datachart,
                    options: this.dataoption
            });
            
            this.chart.update();
            if (this.dataoption.showAllTooltips){
                Chart.pluginService.register({
                    beforeRender: function (chart) {
                        if (chart.config.options.showAllTooltips) {
                            // create an array of tooltips
                            // we can't use the chart tooltip because there is only one tooltip per chart
                            chart.pluginTooltips = [];
                            chart.config.data.datasets.forEach(function (dataset, i) {
                                chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                                    chart.pluginTooltips.push(new Chart.Tooltip({
                                        _chart: chart.chart,
                                        _chartInstance: chart,
                                        _data: chart.data,
                                        _options: chart.options.tooltips,
                                        _active: [sector]
                                    }, chart));
                                });
                            });

                            // turn off normal tooltips
                            chart.options.tooltips.enabled = false;
                        }
                    },
                    afterDraw: function (chart, easing) {
                        if (chart.config.options.showAllTooltips) {
                            // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
                            if (!chart.allTooltipsOnce) {
                                if (easing !== 1)
                                    return;
                                chart.allTooltipsOnce = true;
                            }

                            // turn on tooltips
                            chart.options.tooltips.enabled = true;
                            Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                                tooltip.initialize();
                                tooltip.update();
                                // we don't actually need this since we are not animating tooltips
                                tooltip.pivot();
                                tooltip.transition(easing).draw();
                            });
                            chart.options.tooltips.enabled = false;
                        }
                    }
                });
            }
           
        }
    }
}
</script>