var wflowChart = null;
var wflowlatestId = null;
var arrayMaxSize = 100;

var wflowbgColor = 'rgba(255, 93, 42, 0.2)';
var wflowbColor = 'rgba(255, 93, 42, 1)';

$(function() {
    wflowloadGraph();
});

function wflowloadGraph() {

    var id = [];
    var humiValue = [];
    var waterLevelValue = [];
    var waterFlowValue = [];
    var time = [];

    var api_url = "https://drainagemonitoring.000webhostapp.com/drainage/read.php?limit=" + arrayMaxSize;

    $.ajax({
        url: api_url,
        success: function(responseData) {
            // console.log(responseData);

            $.each(responseData.records, function(i, item) {
                id[i] = item.id;
                humiValue[i] = item.humidity;
                waterLevelValue[i] = item.water_level;
                waterFlowValue[i] = item.water_flow;
                time[i] = addDate(item.created_at);
            });

            wflowlatestId = id[0];
            id = id.reverse();
            humiValue = humiValue.reverse();
            waterLevelValue = waterLevelValue.reverse();
            waterFlowValue = waterFlowValue.reverse();
            time = time.reverse();

            loadWFlowChart(waterFlowValue, time);
        }
    });
}

function wflowchartUpdate() {
    var id;
    var humiValue;
    var waterLevelValue;
    var waterFlowValue;
    var time;
    var api_url = "https://drainagemonitoring.000webhostapp.com/drainage/read.php?limit=1";

    $.ajax({
        url: api_url,
        success: function(responseData) {

            $.each(responseData.records, function(i, item) {
                id = item.id;
                humiValue = item.humidity;
                waterLevelValue = item.water_level;
                waterFlowValue = item.water_flow;
                time = addDate(item.created_at);
            });
            // console.log(id);
            if (wflowlatestId < id) {
                wflowMoveChart(wflowChart, waterFlowValue, time);
                wflowlatestId = id;
            }

        }
    });
}

function addDate(lateDate) {
    var newDate = moment(lateDate).add(8, 'hours').format('YYYY-MM-DD hh:mm:ss');
    return newDate;
}

function loadWFlowChart(value, time) {
    var chartDiv = "wflow_chart_div"
    var chartCanvas = "wflow_chart_canvas";
    var chartLabel = "Water Flow";
    var graphType = document.getElementById("wflowGraphType").value;;
    var bgColor = wflowbgColor;
    var bColor = wflowbColor;
    var colors = wflowgraphColors(bgColor, bColor, graphType, value.length)

    wflowviewGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, colors[0], colors[1]);
}

function wflowgraphColors(bgColor, bColor, graphType, arrayLength) {
    var bgColorArray = [];
    var bColorArray = [];
    var index = 0;

    if (graphType == "bar") {

        while (index <= arrayLength) {

            bgColorArray[index] = bgColor;
            bColorArray[index] = bColor;
            index++;
        }
    } else {
        bgColorArray[0] = bgColor;
        bColorArray[0] = bColor;
    }

    return [bgColorArray, bColorArray];
}

function wflowMoveChart(chart, value, time) {

    if (chart.data.labels.length >= arrayMaxSize) {
        // console.log(chart.data.labels.length);
        chart.data.labels.splice(0, 1); // remove first label
        chart.data.datasets.forEach(function(dataset) {
            dataset.data.splice(0, 1); // remove first data point
        });
        chart.update();
    }

    // Add new data
    chart.data.labels.push(time); // add new label at end
    chart.data.datasets.forEach(function(dataset, index) {
        dataset.data.push(value); // add new data at end
        dataset.backgroundColor.push(wflowbgColor); // add new data at end
        dataset.borderColor.push(wflowbColor); // add new data at end
    });

    chart.update();
}


function wflowviewGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, bgColor, bColor) {

    var pieChartContent = document.getElementById(chartDiv);
    pieChartContent.innerHTML = '&nbsp;';
    $('#' + chartDiv).append('<canvas id="' + chartCanvas + '"  width="100%" height="40vh" ><canvas>');

    var ctx = document.getElementById(chartCanvas).getContext('2d');
    wflowChart = new Chart(ctx, {
        type: graphType,
        data: {
            labels: time,
            datasets: [{
                label: chartLabel,
                data: value,
                backgroundColor: bgColor,
                borderColor: bColor,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    ticks: {
                        callback: function(value) {
                            return value.substr(11); //truncate
                        },
                    }
                }]
            },
            tooltips: {
                enabled: true,
                mode: 'label',
                callbacks: {
                    title: function(tooltipItems, data) {
                        var idx = tooltipItems[0].index;
                        return 'Date: ' + data.labels[idx]; //do something with title
                    },
                    label: function(tooltipItems, data) {
                        //var idx = tooltipItems.index;
                        //return data.labels[idx] + ' €';
                        return "Water Flow: " + tooltipItems.yLabel + ' L/min';
                    }
                }
            }
        }
    });
}