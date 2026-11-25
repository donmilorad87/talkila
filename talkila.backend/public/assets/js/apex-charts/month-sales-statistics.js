(function($) {
    "use strict";
    jQuery(document).on('ready', function() {

        if(typeof seriesForChart === 'string') {
            series = JSON.parse(seriesForChart);
        }

        var options = {
            chart: {
                height: 320,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '35%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['transparent']
            },
            colors: ['#6a4ffc', '#2962ff', '#a64edd'],
            series: seriesForChart,
            xaxis: {
                categories: months_for_chart,
                labels: {
                    style: {
                        colors: '#686c71',
                        fontSize: '12px',
                    },
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return  val
                    }
                }
            },
            legend: {
                offsetY: -10,
            },
            grid: {
                show: true,
                borderColor: '#f6f6f7',
            },
            yaxis: {
                labels: {
                    style: {
                        color: '#686c71',
                        fontSize: '12px',
                    },
                },
                axisBorder: {
                    show: false,
                    color: '#f6f6f7',
                },
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#month-sales-statistics"),
            options
        );

        chart.render();

    });
}(jQuery))
