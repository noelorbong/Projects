var humiChart = null;
var humiLatestId = null;
var arrayMaxSize = 100;
var humbgColor = 'rgba(2, 101, 10, 0.2)';
var humbColor = 'rgba(2, 101, 10, 1)';

$(function() {
    humiLoadGraph();
});

function humiLoadGraph() {

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

            humiLatestId = id[0];
            id = id.reverse();
            humiValue = humiValue.reverse();
            waterLevelValue = waterLevelValue.reverse();
            waterFlowValue = waterFlowValue.reverse();
            time = time.reverse();

            loadHumiChart(humiValue, time);

        }
    });
}

function humiChartUpdate() {
    var id;
    var humiValue;
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
            if (humiLatestId < id) {
                humiMoveChart(humiChart, humiValue, time);
                humiLatestId = id;
            }

        }
    });
}

function addDate(lateDate) {
    var newDate = moment(lateDate).add(8, 'hours').format('YYYY-MM-DD hh:mm:ss');
    return newDate;
}


function loadHumiChart(value, time) {
    var chartDiv = "humi_chart_div"
    var chartCanvas = "humi_chart_canvas";
    var chartLabel = "Obstruction Level";
    var graphType = document.getElementById("humiGraphType").value;;
    var bgColor = humbgColor;
    var bColor = humbColor;
    var colors = HumigraphColors(bgColor, bColor, graphType, value.length)

    viewHumGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, colors[0], colors[1]);
}

function HumigraphColors(bgColor, bColor, graphType, arrayLength) {
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

function humiMoveChart(chart, value, time) {

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
        dataset.backgroundColor.push(humbgColor); // add new data at end
        dataset.borderColor.push(humbColor); // add new data at end
    });

    chart.update();
}


function viewHumGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, bgColor, bColor) {

    var pieChartContent = document.getElementById(chartDiv);
    pieChartContent.innerHTML = '&nbsp;';
    $('#' + chartDiv).append('<canvas id="' + chartCanvas + '"  width="100%" height="40vh" ><canvas>');

    var ctx = document.getElementById(chartCanvas).getContext('2d');
    humiChart = new Chart(ctx, {
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
                        return "Humidity: " + tooltipItems.yLabel + ' %';
                    }
                }
            }
        }
    });
}