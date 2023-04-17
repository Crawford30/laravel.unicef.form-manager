<template>
<div>
    <div :id="barId" style="width: 100%;" class="mt-3"></div>
</div>
</template>

<script>
export default {
    props: {
        data: {
            type: Array,
            required: true
        },
        barId: {
            type: String,
            required: true
        },
        textSize: {
            type: Number,
            required: false,
            default: 14
        },
        categoryHeight: {
            type: Number,
            required: false,
            default: 40
        },
        barType: {
            type: String,
            required: false,
            default: 'data'
        }
    },
    data() {
        return {
            color: '#0079ea',
        }
    },
    mounted() {
        this.buildChart();
    },
    methods: {
        buildChart() {
            let app = this;
            var options = {
                chart: {
                    type: 'bar',
                    style: {
                        fontFamily: 'Poppins, Avenir'
                    },
                    events: {
                        load: function() {
                            this.update({
                                chart: {
                                    height: app.categoryHeight * this.pointCount + (this.chartHeight - this.plotHeight)
                                }
                            })
                        }
                    }
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: app.data.map(x => x.name),
                    gridLineWidth: 0,
                    lineWidth: 0,
                    tickWidth: 0,
                    labels: { 
                        enabled: true,
                        align: 'right',
                        style: { 
                            fontSize: app.textSize + 'px',
                            width: '260px',
                            'min-width': '260px',
                            'text-align': 'right',
                            'padding-right': '15px',
                            'cursor': 'pointer',
                        },
                        events: {
                            click: function () { 
                                var form = app.data[this.pos];
                                if(Object.keys(form).includes('id')) {
                                    window.location.href = '/data-forms/' + form.id;
                                }
                            }
                        },
                        useHTML : true
                    }
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        enabled: false
                    },
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    startOnTick: false,
                    endOnTick: false,
                    tickPositions: [],
                    lineWidth: 0,
                    tickWidth: 0,
                    visible: false
                },
                tooltip: {
                    shared: true,
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    bar: {
                        pointPadding: 0,
                        groupPadding: 0.2,
                        dataLabels: {
                            enabled: true,
                            formatter() {
                                let text = this.y > 1 ? 'viewers' : 'viewer';
                                return app.barType == 'data' ? this.y : this.y + ' ' + text;
                            }
                        }
                    }
                },
                series: [{
                    name: app.barType == 'data' ? "Data collected" : "Viewers",
                    data: app.data.map(d => parseInt(d.data)),
                    color: app.color,
                    fillColor: {
                        linearGradient: [0, 0, 0, 300],
                        stops: [
                            [0, app.color],
                            [1, Highcharts.Color(app.color).setOpacity(0).get('rgba')]
                        ]
                    },
                }]
            };
            Highcharts.chart(app.barId, options);
        }
    },
    watch: {
        data: function(newVal, oldVal) {
            this.data = newVal;
            this.buildChart();
        }
    }
}
</script>

<style scoped>

</style>
