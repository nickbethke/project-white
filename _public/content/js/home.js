"use strict";

requirejs(['lib/svg', 'lib/apexcharts'], (svg, ApexCharts) => {

    Apex.colors = ['#1F2937', '#31921f', '#d4d4cb', '#FFC548'];

    let options = {
        chart: {
            type: 'pie',
            toolbar: {
                show: false
            },
            height: '100%',
            fontFamily: "Open Sans, sans-serif"
        },
        dataLabels: {
            enabled: false
        },
        series: [],
        labels: ["Closed", "Open", "In Progress", "Waiting"],
        legend: {
            position: 'bottom',
            formatter: function (seriesName, opts) {
                return [seriesName, " - ", opts.w.globals.series[opts.seriesIndex]]
            }
        },
        noData: {
            text: 'Loading...'
        }
    }

    let chart = new ApexCharts(document.querySelector("#time-flow"), options);

    chart.render();

})

