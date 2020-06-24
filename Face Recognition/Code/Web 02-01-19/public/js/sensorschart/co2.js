var co2Chart = null;
var co2LatestId = null;
var co2arrayMaxSize = 100;

$(function() {
    co2requestData()
    setInterval(function() { co2RequestDataUpdate() }, 2000);
});

function co2requestData() {

    var id = [];
    var value = [];
    var time = [];
    var currentDate = "";
    var getFirstDataTime = true;

    $.ajax({
        url: "/realtimeco2/",
        success: function(responseData) {
            $.each(responseData.co2, function(i, item) {
                id[i] = item.id;
                value[i] = item.value;
                time[i] = " " + (item.created_at).slice(11) + " ";
                if (getFirstDataTime) {
                    document.getElementById('co2CurrentDate').innerHTML = "<b>Current Date: </b>" + (item.created_at).slice(0, 11);
                    getFirstDataTime = false;
                }
            });

            //console.log("Array Size:" + id.length);
            var arrayLength = id.length;
            var difference = co2arrayMaxSize - arrayLength;

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

            co2LatestId = id[0];

            co2DisplayChart(value, time);
        }
    });
}

function co2RequestDataUpdate() {
    var id;
    var value;
    var time;
    var currentDate = "";
    $.ajax({
        url: "/realtimeco2update/",
        success: function(responseData) {
            $.each(responseData.co2, function(i, item) {
                id = item.id;
                value = item.value;
                time = " " + (item.created_at).slice(11) + " ";
                document.getElementById('co2CurrentDate').innerHTML = "<b>Current Date: </b>" + (item.created_at).slice(0, 11);
            });


            if (co2LatestId < id) {
                co2MoveChart(co2Chart, value, time);
                co2LatestId = id;
            }

        }
    });
}

function co2MoveChart(chart, value, time) {
    //console.log(chart.data.labels.length);
    if (chart.data.labels.length >= co2arrayMaxSize) {
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
        dataset.backgroundColor.push('rgba(255, 0, 38, 0.2)'); // add new data at end
        dataset.borderColor.push('rgba(255, 0, 38, 1)'); // add new data at end
    });

    chart.update();
}

function co2DisplayChart(value, time) {
    var graphStyle = document.getElementById("co2GraphType").value;
    var arrayBackgroundColor = [];
    var arrayborderColor = [];

    if (graphStyle == "bar") {

        var i;
        for (i = 0; i < time.length; i++) {
            arrayBackgroundColor[i] = 'rgba(255, 0, 38, 0.2)';
            arrayborderColor[i] = 'rgba(255, 0, 38, 1)';
        }
    } else {
        arrayBackgroundColor[0] = 'rgba(255, 0, 38, 0.2)';
        arrayborderColor[0] = 'rgba(255, 0, 38, 1)';
    }

    var pieChartContent = document.getElementById('co2chartContent');
    pieChartContent.innerHTML = '&nbsp;';
    $('#co2chartContent').append('<canvas id="co2Chart"  width="100%" height="35vh" ><canvas>');

    var ctx = document.getElementById("co2Chart").getContext('2d'); //$("#humiChart").get(0).getContext("2d"); 
    //
    co2Chart = new Chart(ctx, {
        type: graphStyle,
        data: {
            labels: time,
            datasets: [{
                label: ' CO2',
                data: value,
                backgroundColor: arrayBackgroundColor,
                borderColor: arrayborderColor,
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.yLabel;
                    }
                }
            }
        }
    });
}