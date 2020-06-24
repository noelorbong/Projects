var tempChart = null;
var arrayMaxSize = 100;
$(function() {
    requestData()
});


function handler() {
    var startTime = document.getElementById("startTime").value;
    var endTime = document.getElementById("endTime").value;
    // alert(e.target.value);
    temprequestData(startTime, endTime);
    console.log(startTime);
    console.log(endTime);
}

function requestData() {

    var id = [];
    var value = [];
    var time = [];
    var datetime = [];
    $.ajax({
        url: "/realtimetemp/",
        success: function(responseData) {
            $.each(responseData.temperatures, function(i, item) {
                id[i] = item.id;
                value[i] = item.value;
                time[i] = item.created_at;
                datetime[i] = item.created_at;
            });
            document.getElementById("endTime").value = formatDate(datetime[0]);
            document.getElementById("startTime").value = formatDate(datetime[datetime.length - 1]);
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
            // }

            displayChart(value, time);
        }
    });
}

function formatDate(newDate) {
    var date = new Date(newDate);
    var nyear = date.getFullYear();
    var nmonth = ((date.getMonth() + 1).toString().length == 2 ? (date.getMonth() + 1) : "0" + (date.getMonth() + 1));
    var nday = ((date.getDate()).toString().length == 2 ? (date.getDate()) : "0" + (date.getDate()));
    var nhour = ((date.getHours()).toString().length == 2 ? (date.getHours()) : "0" + (date.getHours()));
    var nmin = ((date.getMinutes()).toString().length == 2 ? (date.getMinutes()) : "0" + (date.getMinutes()));
    /// console.log((date.getHours()).toString().length)
    var retrunDate = nyear + "-" + nmonth + "-" + nday + "T" + nhour + ":" + nmin;
    console.log("ReturnDate: " + retrunDate);
    console.log(date);
    console.log(newDate);
    var newFortmat = date.toISOString().slice(0, 16);
    console.log(newFortmat);
    return retrunDate;
}

function temprequestData(startTime, endTime) {

    var id = [];
    var value = [];
    var time = [];
    var currentDate = "";
    var getFirstDataTime = true;
    // console.log("Date:" + date)
    $.ajax({
        url: "/selectedtempdate/" + startTime.toString() + "/" + endTime.toString(),
        success: function(responseData) {
            $.each(responseData.temperatures, function(i, item) {
                id[i] = item.id;
                value[i] = item.value;
                time[i] = item.created_at;
            });

            console.log("Array Size:" + id.length);
            var arrayLength = id.length;

            value = value.reverse();
            time = time.reverse();

            displayChart(value, time);
        }
    });
}

function displayChart(value, time) {

    var graphStyle = document.getElementById("graphType").value;
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