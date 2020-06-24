@extends('layouts.coreuiadmin')

@section('title')
Dashboard ICu Environment
@endsection

@section('bodyTitle')
Dashboard
@endsection

@section('customCSS')
@endsection
<style type="text/css">
	/* #camera{
        height: calc(100% - (25px + 500px));
		width:100%;
	} */

</style>
@section('content')
<div class="row">
    <div class="col-sm-12 col-xl-3">
    <!-- <img style="height:40vh; width:100%" style="-webkit-user-select: none;" id="camera"> -->
        <!-- <iframe  style="height:40vh; width:100%" id="camera"></iframe> -->
        <div class="card"> 
            <div class="card-header">
                <i class="nav-icon fa fa-camera"></i> Camera
            </div>
            <div id="camera-body" class="card-body"  style="padding:5px">
                 <img style="height:auto; width: 100%; object-fit: contain;display: block;margin-left: auto; margin-right: auto;" id="camera">
            </div>
            <div class="card-footer text-muted">
                <a class="pull-right"  href="/camera" target="_blank">More</a>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-xl-6">
        <div class="card"> 
            <div class="card-header">
                <i class="nav-icon fa fa-folder-open"></i> Last Data
            
            </div>
            <div class="card-body" style="padding:0; margin:0;">
                <div class="row justify-content-md-center" style="text-align:center">
                    <div class="col-sm-6 col-xl-3" style="height:110px; display:table;">
                        <div style="display: table-cell; vertical-align: middle;">
                            <h4 style="font-weight:bold"> Temperature</h4>
                            <h5 id="temperatureValue" style="font-weight:bold">0 °C</h5>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3" style="height:110px; display:table;">
                        <div style="display: table-cell; vertical-align: middle;">
                            <h4 style="font-weight:bold">Humidity</h4>
                            <h5 id="humidityValue" style="font-weight:bold">0 %</h5>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3" style="height:110px; display:table;">
                        <div style="display: table-cell; vertical-align: middle;">
                            <h4 style="font-weight:bold">CO2</h4>
                            <h5 id="co2Value" style="font-weight:bold">0 ppm</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <span  id="senCurrentDate" class="text-muted pull-left" ></span>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12 col-xl-3">
        <div class="card"> 
            <div class="card-header">
            <i class="nav-icon fa fa-plug"></i> Devices
            </div>
            <div class="card-body" style="padding-bottom:30px; padding-top:30px; height:auto; width: 100%; object-fit: contain; display: block;">
                <div class="row"   >
                    <div class="col-sm-6 col-xl-6">
                        <h5 class="card-title text-center">Fan</h5>
                        <img  style="height:auto; width: 100%; object-fit: contain;display: block;margin-left: auto; margin-right: auto;" id="electricFan" src="/img/icons/icon_fan_off.png">
                    </div>
                    <div class="col-sm-6 col-xl-6">
                        <h5 class="card-title text-center">Buzzer</h5>
                        <img  style="height:auto; width: 100%; object-fit: contain;display: block;margin-left: auto; margin-right: auto;" id="alarmBuzzer" src="/img/icons/icon_alarm_off.png">
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a class="pull-right"  href="/devices" target="_blank">More</a>
            </div>
        </div>
    </div>
    
    
    <div class="col-sm-12 col-xl-6">
        <div class="card"> 
            <div class="card-header">
            <i class="nav-icon fa fa-flask"></i> CO2
            <span class="pull-right">
                Graph Type: <select id="co2GraphType" onChange="co2requestData()">
                        <option value="line" >Line</option>
                        <option value="bar" >Bar</option>
                    </select>
            </span>
            </div>
            <div class="card-body" style="padding:0; margin:0;">
                <div id="co2chartContent" >
                    <canvas id="co2Chart"  width="100%" height="25vh"></canvas>
                </div>
            </div>
            <div class="card-footer text-muted">
                <span  id="co2CurrentDate" class="text-muted pull-left" ></span>
                <a class="pull-right"  href="/co2" target="_blank">More</a>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12 col-xl-6">
        <div  class="card"> 
            <div class="card-header">
            <i class="nav-icon fa fa-thermometer-half"></i>  Temperature
            <span class="pull-right">
                Graph Type: <select id="tempGraphType" onChange="requestData()">
                        <option value="line" >Line</option>
                        <option value="bar" >Bar</option>
                    </select>
            </span>
            </div>
            <div class="card-body" style="padding:0; margin:0;">
                <div id="chartContent" >
                    <canvas id="tempChart"  width="100%" height="40vh"></canvas>
                </div>
            </div>
            <div class="card-footer text-muted">
                <span  id="tempCurrentDate" class="text-muted pull-left" ></span>
                <a class="pull-right"  href="/temperature" target="_blank">More</a>
            </div>
        </div>
    </div>  

    
    
    <div class="col-sm-12 col-xl-6">
        <div class="card"> 
            <div class="card-header">
                <i class="nav-icon fa fa-tint"></i> Humidity<span class="pull-right">
                Graph Type: <select id="humiGraphType" onChange="humirequestData()">
                        <option value="line" >Line</option>
                        <option value="bar" >Bar</option>
                    </select>
            </span>
            </div>
            <div class="card-body" style="padding:0; margin:0;">
                <div id="humichartContent" >
                    <canvas id="humiChart"  width="100%" height="40vh"></canvas>
                </div>
            </div>
            <div class="card-footer text-muted">
                <span  id="humiCurrentDate" class="text-muted pull-left" ></span>
                <a class="pull-right"  href="/humidity" target="_blank">More</a>
            </div>
        </div>
    </div>       
</div>
@endsection

@section('customScript')
<script type="text/javascript">
    $(function() {
        // var clientHeight = document.getElementById('camera-body').clientHeight;
        // document.getElementById("camera").style.height = (clientHeight-10).toString()+"px";
        // console.log(clientHeight);
        // console.log(clientHeight-10);
        document.getElementById('camera').src = window.location.protocol + "//" + window.location.hostname + ":8081/";
        
        // $(window).resize(function() {
        //     console.log("Window Change");
        //     clientHeight = document.getElementById('camera-body').clientHeight;
        //     document.getElementById("camera").style.height = (clientHeight-10).toString()+"px";
        //     console.log(clientHeight-10);
        // });
    });
</script>
<script src="../js/sensorschart/temperature.js"></script>
<script src="../js/sensorschart/humidity.js"></script>
<script src="../js/sensorschart/co2.js"></script>
<script src="../js/sensorschart/device.js"></script>
@endSection
