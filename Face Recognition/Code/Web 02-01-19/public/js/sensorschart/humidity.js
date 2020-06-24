var humiChart = null;
var humiLatestId = null;
var arrayMaxSize = 100;

$(function() {
    humirequestData()
    setInterval(function() { humiRequestDataUpdate() }, 5000);
});

function humirequestData() {

    var id = [];
    var value = [];
    var time = [];
    var currentDate = "";
    var getFirstDataTime = true;

    $.ajax({
        url: "/realtimehumi/",
        success: function(responseData) {
            $.each(responseData.humidities, function(i, item) {
                id[i] = item.id;
                value[i] = item.value;
                time[i] = " " + (item.created_at).slice(11) + " ";
                if (getFirstDataTime) {
                    document.getElementById('humiCurrentDate').innerHTML = "<b>Current Date: </b>" + (item.created_at).slice(0, 11);
                    getFirstDataTime = false;
                }
            });

            //console.log("Array Size:" + id.length);
            var arrayLength = id.length;
            var difference = arrayMaxSize - arrayLength;

            value = value.reverse();
            time = time.reverse();

            // if(difference > 0){
            //     var i;
            //     for (i = 0; i < difference; i++) { 
            //         id[arrayLength+i] = 0;
            //         value[arrayLength+i] = "";
            //         time[arrayLength+i] = "";
            //     }
            //    // console.log("Array Size2:" + id.length);
            // }

            humiLatestId = id[0];

            humiDisplayChart(value, time);
        }
    });
}

function humiRequestDataUpdate() {
    var id;
    var value;
    var time;
    var currentDate = "";
    $.ajax({
        url: "/realtimehumiupdate/",
        success: function(responseData) {
            $.each(responseData.humidities, function(i, item) {
                id = item.id;
                value = item.value;
                time = " " + (item.created_at).slice(11) + " ";
                document.getElementById('humiCurrentDate').innerHTML = "<b>Current Date: </b>" + (item.created_at).slice(0, 11);
            });

            //console.log("humiLatestId: "+ humiLatestId);
            //console.log("Id: "+ id);
            // if (humiLatestId < id) {
            humiMoveChart(humiChart, value, time);
            //     humiLatestId = id;
            // }

        }
    });
}

function humiMoveChart(chart, value, time) {
    if (chart.data.labels.length >= arrayMaxSize) {
        console.log(chart.data.labels.length);
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
        dataset.backgroundColor.push('rgba(234, 114, 9, 0.2)'); // add new data at end
        dataset.borderColor.push('rgba(234, 114, 9, 1)'); // add new data at end
    });

    chart.update();
}

function humiDisplayChart(value, time) {
    var graphStyle = document.getElementById("humiGraphType").value;
    var arrayBackgroundColor = [];
    var arrayborderColor = [];

    if (graphStyle == "bar") {

        var i;
        for (i = 0; i < time.length; i++) {
            arrayBackgroundColor[i] = 'rgba(234, 114, 9, 0.2)';
            arrayborderColor[i] = 'rgba(234, 114, 9, 1)';
        }
    } else {
        arrayBackgroundColor[0] = 'rgba(234, 114, 9, 0.2)';
        arrayborderColor[0] = 'rgba(234, 114, 9, 1)';
    }

    var pieChartContent = document.getElementById('humichartContent');
    pieChartContent.innerHTML = '&nbsp;';
    $('#humichartContent').append('<canvas id="humiChart"  width="100%" height="40vh" ><canvas>');

    var ctx = document.getElementById("humiChart").getContext('2d'); //$("#humiChart").get(0).getContext("2d"); 
    //
    humiChart = new Chart(ctx, {
        type: graphStyle,
        data: {
            labels: time,
            datasets: [{
                label: ' Humidity',
                data: value,
                backgroundColor: arrayBackgroundColor,
                borderColor: arrayborderColor,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }
                        label += Math.round(tooltipItem.yLabel * 100) / 100;
                        return label + ' ';
                    }
                }
            }
        }
    });
}