var mainChart = null;
var currentDate;
var wflowbgColor = 'rgba(255, 93, 42, 0.2)';
var wflowbColor = 'rgba(255, 93, 42, 1)';
var dataId = [];
var humiValue = [];
var waterLevelValue = [];
var waterFlowValue = [];
var datatime = [];

$(function() {
    firstReadFromDatabase();
});

function changeGraph() {
    intializeGraphVariables(waterFlowValue, datatime);
}

function pickDate(e) {
    sendRequest(e.target.value);
}

function firstReadFromDatabase() {
    var requestDate = getCurrentDate();
    document.getElementById("selectDate").value = requestDate;
    sendRequest(requestDate)
}

function sendRequest(requestDate) {
    currentDate = requestDate;
    var yesterDay = minusDate(requestDate);
    // console.log(yesterDay);

    var startdate = yesterDay + " 16:00:00";
    var enddate = requestDate + " 16:00:00";

    dataId = [];
    humiValue = [];
    waterLevelValue = [];
    waterFlowValue = [];
    datatime = [];

    var api_url = "https://drainagemonitoring.000webhostapp.com/drainage/readdate.php?startdate=" + startdate + "&enddate=" + enddate;

    $.ajax({
        url: api_url,
        success: function(responseData) {
            // console.log(responseData);

            $.each(responseData.records, function(i, item) {
                dataId[i] = item.id;
                humiValue[i] = item.humidity;
                waterLevelValue[i] = item.water_level;
                waterFlowValue[i] = item.water_flow;
                datatime[i] = addDate(item.created_at);
            });

            dataId = dataId.reverse();
            humiValue = humiValue.reverse();
            waterLevelValue = waterLevelValue.reverse();
            waterFlowValue = waterFlowValue.reverse();
            datatime = datatime.reverse();

            intializeGraphVariables(waterFlowValue, datatime);
        }
    });
}

function minusDate(advanceDate) {
    var newDate = new Date(advanceDate);
    newDate.setDate(newDate.getDate() - 1);
    var dd = newDate.getDate();
    var mm = newDate.getMonth() + 1;
    var yyyy = newDate.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }

    newDate = yyyy + '-' + mm + '-' + dd;

    return newDate;
}

function addDate(lateDate) {
    var newDate = moment(lateDate).add(8, 'hours').format('YYYY-MM-DD hh:mm:ss');
    return newDate;
}

function getCurrentDate() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }
    today = yyyy + '-' + mm + '-' + dd;
    return today;
}

function intializeGraphVariables(value, time) {
    var chartDiv = "wflow_chart_div"
    var chartCanvas = "wflow_chart_canvas";
    var chartLabel = "Water Flow";
    var graphType = document.getElementById("wflowGraphType").value;;
    var bgColor = wflowbgColor;
    var bColor = wflowbColor;
    var colors = graphColors(bgColor, bColor, graphType, value.length)

    loadGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, colors[0], colors[1]);
}

function graphColors(bgColor, bColor, graphType, arrayLength) {
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

function loadGraph(chartDiv, chartCanvas, chartLabel, graphType, value, time, bgColor, bColor) {

    var pieChartContent = document.getElementById(chartDiv);
    pieChartContent.innerHTML = '&nbsp;';
    $('#' + chartDiv).append('<canvas id="' + chartCanvas + '"  width="100%" height="40vh" ><canvas>');

    var ctx = document.getElementById(chartCanvas).getContext('2d');
    mainChart = new Chart(ctx, {
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