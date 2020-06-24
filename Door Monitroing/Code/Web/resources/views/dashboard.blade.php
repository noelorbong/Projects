@extends('layouts.coreuiadmin')

@section('title')
Dashboard Door Monitoring
@endsection

@section('bodyTitle')
Dashboard
@endsection

@section('customCSS')
<style>
.v-wrap{
    height: 100%;
    white-space: nowrap;
    text-align: center;
}
.v-wrap:before{
    content: "";
    display: inline-block;
    vertical-align: middle;
    width: 0;
    /* adjust for white space between pseudo element and next sibling */
    margin-right: -.25em;
    /* stretch line height */
    height: 100%; 
}
.v-box{
    display: inline-block;
    vertical-align: middle;
    white-space: normal;
}
  tbody {
    display:block;
    height:55vh;
    overflow:auto;
    background-color:#ffffff;
  }
  thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;/* even columns width , fix width of table too*/
  }
  thead {
    width: calc( 100% - 1em )/* scrollbar is average 1em/16px width, remove it from thead width */
  }
  .table {
    width:100%;
    background-color: #23282c !important;
    min-width:699px;
  }
</style>
@endsection

@section('content')
@section('content')
<div class="row justify-content-md-center">
    <div class="col-sm-12 col-xl-5">
    <!-- <img style="height:40vh; width:100%" style="-webkit-user-select: none;" id="camera"> -->
        <!-- <iframe  style="height:40vh; width:100%" id="camera"></iframe> -->
        <div class="card"> 
            <div class="card-header">
                <i class="nav-icon fa fa-camera"></i> Camera
                <span class="pull-right">
                    <div class="form-inline my-2 my-lg-0">
                        <a href="/camera">More..</a>
                    </div>
                </span>
            </div>
            <div id="camera-body" class="card-body"  style="padding:5px; height:35vh">
                <img style="width: 100%; height:100%; display: block;margin-left: auto; margin-right: auto;" id="camera">
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-7">
        <div class="card"> 
            <div class="card-header">
                <i class="nav-icon fa fa-folder-open"></i> Current Log Counter
                <span class="pull-right">
                    <div class="form-inline my-2 my-lg-0">
                        <span id="currentDate"></span>
                    </div>
                </span>
            </div>
            <div class="card-body"  style=" height:35vh">
            <div class="brand-card"  style="height:100%">
            <div class="brand-card-body" style="height:100%" >
                <div style="height:100%">
                    <div class="v-wrap">
                        <article class="v-box">
                            <div id="sensor" class="text-value">0</div>
                            <div class="text-uppercase text-muted small">No. of Motion Detected</div>
                        </article>
                    </div>
                </div>
                <div style="height:100%">
                    <div class="v-wrap">
                        <article class="v-box">
                            <div id="email" class="text-value">0</div>
                            <div class="text-uppercase text-muted small">No. of  Email Sent</div>
                        </article>
                    </div>
                   
                </div>
                <div style="height:100%">
                    <div class="v-wrap">
                        <article class="v-box">
                            <div id="sms" class="text-value">0</div>
                            <div class="text-uppercase text-muted small">No. of  SMS Sent</div>
                        </article>
                    </div>
                    
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <i class="nav-icon fa fa-list-alt"></i> Current Sensor Log 
                <span class="pull-right">
                    <div class="form-inline my-2 my-lg-0">
                        <a href="/sensorlog">More..</a>
                    </div>
                </span>
            </div>
            <div class="card-body" style="padding:0px; margin:0;">
                <div class="table-responsive">
                <table class="table text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Message
                            </th>
                            <th scope="col">Date Created
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
                </div>
            </div>
            <div class="card-footer text-muted">
                Date: <span id="selectDate" ></span>
                &nbsp; &nbsp; No. Of Record: <span id="recordHolder"> 0<span>
            </div>
        </div>
    </div>
</div><!--/.row-->

@endsection

@section('customScript')
<script type="text/javascript">
 var currentDate = formatDate();
 var motionCounter;
 var windowLocation = "";
    $(function() { 
        // windowLocation = "/cameraalone"//window.location.protocol + "//" + window.location.hostname + ":8081/";
        // document.getElementById('camera').src = windowLocation;   
        windowLocation = window.location.protocol + "//" + window.location.hostname + ":8081/";
        document.getElementById('camera').src = windowLocation; 
        document.getElementById('selectDate').innerHTML = currentDate;
        document.getElementById('currentDate').innerHTML = currentDate;
        requestCounter();
        setInterval(function(){ requestCounter() }, 3000);
    });

    function formatDate(){
        var date = new Date();
        var nyear = date.getFullYear();
        var nmonth = ((date.getMonth()+1).toString().length == 2 ? (date.getMonth()+1) : "0"+(date.getMonth()+1));
        var nday = ((date.getDate()).toString().length == 2 ? (date.getDate()) : "0"+(date.getDate()));
        var retrunDate =  nyear + "-" + nmonth + "-" + nday;
        
    // console.log(retrunDate);
        
        return retrunDate;
    }

     function firstReadFromDatabase() {
            var requestDate = currentDate;
            document.getElementById("selectDate").value = requestDate;
            sendRequest(requestDate)
        }

    function requestCounter(){
   
        $.ajax({url: "/countalllog/"+currentDate, success: function(responseData){
    
            document.getElementById('email').innerHTML = responseData.email.count;
            document.getElementById('sms').innerHTML = responseData.sms.count;
            document.getElementById('sensor').innerHTML = responseData.sensor.count;
            
            if (motionCounter != responseData.sensor.count){
                motionCounter =  responseData.sensor.count;       
                firstReadFromDatabase();
            }               
        }});
    }

    
function sendRequest(requestDate) {
    currentDate = requestDate;

    var startdate = requestDate + " 00:00:00";
    var enddate = requestDate + " 23:59:00";
    rows= "";

    var api_url = "selectsensorlog/"+startdate + "/" + enddate;

    $.ajax({
      url: api_url,
      success: function(responseData) {
        if(responseData.records){
            document.getElementById("recordHolder").innerHTML = responseData.records.length
          }else{
            document.getElementById("recordHolder").innerHTML ='0';
          }
      $.each(responseData.records, function(i, item) {
        rows += "<tr>"
        rows += "<td>Sensor Detected Motion</td>";
        rows += "<td>" + item.created_at + "</td>";
        rows += "</tr>"
      });

      document.getElementById('tbody').innerHTML = '';
      $('#tbody').append(rows);

      }
    });
  }
</script>
@endSection
