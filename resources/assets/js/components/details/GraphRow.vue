<template>
    <div id="chart">

    </div>

</template>

<script>
    export default {
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            }
        },
        mounted() {
            google.charts.load('current', {'packages': ['corechart']});
            var vm = this;
            google.charts.setOnLoadCallback(function() { drawChart(vm); });
            function drawChart(vm) {
                console.log(vm.rowData.chart);
                var data = google.visualization.arrayToDataTable(vm.rowData.chart);
               // data.addColumn('date', 'Date');
               // data.addColumn('number', 'Value');

               // data.addRows(chart);

                var options = {
                    title: 'Company Performance',
                 //   curveType: 'function',
                    legend: {position: 'bottom'}
                };

                var chart = new google.visualization.LineChart(vm.$el);

                chart.draw(data, options);
            }
        },
        methods: {
            onClick(event) {
                console.log('my-detail-row: on-click', event.target)
            }
        },
    }
</script>