var wlevelChart = null;
var wlevellatestId = null;
var arrayMaxSize = 100;
var wlevelbgColor = 'rgba(33, 4, 249, 0.2)';
var wlevelbColor = 'rgba(33, 4, 249, 1)';

$(function() {
    wlevelloadGraph();

});

function wlevelloadGraph() {

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

            wlevellatestId = id[0];
            id = id.reverse();
            humiValue = humiValue.reverse();
            waterLevelValue = waterLevelValue.reverse();
            waterFlowValue = waterFlowValue.reverse();
            time = time.reverse();

            loadWLevelChart(waterLevelValue, time);
        }
    });
}

function wlevelchartUpdate() {
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
            if (wlevellatestId < id) {
                wlevelMoveChart(wlevelChart, waterLevelValue, time);
                wlevellatestId = id;
            }

        }
    });
}

function addDate(lateDate) {
    var newDate = moment(lateDate).add(8, 'hours').format('YYYY-MM-DD hh:mm:ss');
    return newDate;
}

function loadWLevelChart(value, time) {
    var chartDiv = "wlevel_chart_div"
    var chartCanvas = "wlevel_chart_canvas";
    var chartLabel = "Water Level";
    var graphType = document.getElementById("wlevelGraphType").value;;
    var bgColor = wlevelbgColor;
    var bColor = wlevelbColor;
    var colors = wlevelgraphColors(bgColor, bColor, graphType, value.length)

    wlevelviewGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, colors[0], colors[1]);
}


function wlevelgraphColors(bgColor, bColor, graphType, arrayLength) {
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
        bgColorArray[0] = wlevelbgColor;
        bColorArray[0] = wlevelbColor;
    }

    return [bgColorArray, bColorArray];
}

function wlevelMoveChart(chart, value, time) {

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
        dataset.backgroundColor.push(wlevelbgColor); // add new data at end
        dataset.borderColor.push(wlevelbColor); // add new data at end
    });

    chart.update();
}


function wlevelviewGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, bgColor, bColor) {

    var pieChartContent = document.getElementById(chartDiv);
    pieChartContent.innerHTML = '&nbsp;';
    $('#' + chartDiv).append('<canvas id="' + chartCanvas + '"  width="100%" height="40vh" ><canvas>');

    var ctx = document.getElementById(chartCanvas).getContext('2d');
    wlevelChart = new Chart(ctx, {
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
                        return "Water Level: " + tooltipItems.yLabel + ' %';
                    }
                }
            }
        }
    });
}