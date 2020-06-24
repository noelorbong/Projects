var tempChart = null;
var latestId = null;
var arrayMaxSize = 100;
$(function() {
    requestData()
    setInterval(function() { requestDataUpdate() }, 2000);
});

function requestData() {

    var id = [];
    var value = [];
    var time = [];
    var currentDate = "";
    var getFirstDataTime = true;

    $.ajax({
        url: "/realtimetemp/",
        success: function(responseData) {
            $.each(responseData.temperatures, function(i, item) {
                id[i] = item.id;
                value[i] = item.value;
                time[i] = item.created_at;
                if (getFirstDataTime) {
                    document.getElementById('tempCurrentDate').innerHTML = "<b>Current Date: </b>" + (item.created_at).slice(0, 11);
                    getFirstDataTime = false;
                    if (document.getElementById('senCurrentDate')) {
                        document.getElementById('temperatureValue').innerHTML = item.value + " °C";
                        document.getElementById('senCurrentDate').innerHTML = "<b>Current Date: </b>" + item.created_at;
                    }
                    // humidityValue
                    // temperatureValue
                    // co2Value
                    // senCurrentDate
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

            latestId = id[0];

            displayChart(value, time);

        }
    });
}

function requestDataUpdate() {
    var id;
    var value;
    var time;
    var currentDate = "";
    $.ajax({
        url: "/realtimetempupdate/",
        success: function(responseData) {
            $.each(responseData.temperatures, function(i, item) {
                id = item.id;
                value = item.value;
                time = item.created_at;
                document.getElementById('tempCurrentDate').innerHTML = "<b>Current Date: </b>" + (item.created_at).slice(0, 11);

                // humidityValue
                // temperatureValue
                // co2Value
                // senCurrentDate
            });

            // console.log("latest Id: "+ latestId);
            // console.log("Id: "+ id);
            if (latestId < id) {
                if (document.getElementById('senCurrentDate')) {
                    document.getElementById('temperatureValue').innerHTML = value + " °C";
                    document.getElementById('senCurrentDate').innerHTML = "<b>Current Date: </b>" + time;
                }
                moveChart(tempChart, value, time);
                latestId = id;
            }

        }
    });
}

function moveChart(chart, value, time) {
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
        dataset.backgroundColor.push('rgba(25, 8, 139, 0.2)'); // add new data at end
        dataset.borderColor.push('rgba(5, 8, 139, 1)'); // add new data at end
    });

    chart.update();
}

function displayChart(value, time) {
    // var pieChartContent = document.getElementById('chartContent');
    //     pieChartContent.innerHTML = '&nbsp;';
    //     $('#chartContent').append('<canvas id="tempChart"  width="100%" height="40vh" ><canvas>');
    var graphStyle = document.getElementById("tempGraphType").value;
    console.log("graph: " + graphStyle);
    var arrayBackgroundColor = [];
    var arrayborderColor = [];
    if (graphStyle == "bar") {
        var i;
        for (i = 0; i < time.length; i++) {
            arrayBackgroundColor[i] = 'rgba(25, 8, 139, 0.2)';
            arrayborderColor[i] = 'rgba(5, 8, 139, 1)';
        }
    } else {
        arrayBackgroundColor[0] = 'rgba(25, 8, 139, 0.2)';
        arrayborderColor[0] = 'rgba(5, 8, 139, 1)';
    }

    var pieChartContent = document.getElementById('chartContent');
    pieChartContent.innerHTML = '&nbsp;';
    $('#chartContent').append('<canvas id="tempChart"  width="100%" height="40vh" ><canvas>');

    var ctx = document.getElementById("tempChart").getContext('2d'); //$("#tempChart").get(0).getContext("2d"); 
    //
    tempChart = new Chart(ctx, {
        type: graphStyle,
        data: {
            labels: time,
            datasets: [{
                label: ' Temperature',
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
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }
                        label += Math.round(tooltipItem.yLabel * 100) / 100;
                        return label + ' °C';
                    }
                }
            }
        }
    });
}