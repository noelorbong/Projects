<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.0.0
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>ICU Dashboard</title>
    <link rel="shortcut icon" href="/img/brand/favicon.png" type="image/png">
    <!-- Icons-->
    <link href="/node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="/node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="/node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
   
    <!-- Main styles for this application-->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    @yield('customCSS')
    <style>
            html{               
              /* background: url(../img/brand/background.jpg) no-repeat center center fixed;                 -webkit-background-size: cover; */
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
            }

            body {
                /* color: #636b6f; */
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                background-color:black !important;
            }

            body::before
            {
              content: "";
              display: block;
              position: absolute;
              z-index: -1;
              width: 100%;
              height: 100%;
              background:#ffffff;
              opacity: .6;
            }
    </style>
  </head>
  <body >
    <div class="app-body">
      <main class="main">
        <div class="container-fluid" style="padding:15px;">
            <div class="animated fadeIn">
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
    
    
    <div class="col-sm-12 col-xl-4">
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
    
    <div class="col-sm-12 col-xl-4">
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

    
    
    <div class="col-sm-12 col-xl-4">
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
            </div>
        </div>
      </main>

      <div class="modal fade" id="ss_overlay" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: transparent; border-color: transparent;">
          <div class="modal-body" >
            <div class="card">
                <div class="card-header">
                    <i class="nav-icon fa fa-gear"></i> Devices Setting
                    <button style="float:right" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="card-body" style="padding:30px; margin:0;">
                    <form action="/devicesettingupdate" method="POST">
                    {{ csrf_field() }}
                        <!-- <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="enable">Enable Automatic Devices</label>
                              <select class="form-control" id="enable" name="enable">
                                  <option value=0>False</option>
                                  <option value=1>True</option>
                              </select>
                            </div>
                        </div> -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="max_temperature">Maximum Temperature</label>
                              <input type="number" class="form-control "  name="max_temperature" id="max_temperature"  required />
                            </div>
                            <div class="form-group col-md-6">
                              <label for="max_co2">Maximum CO2 </label>
                              <input  class="form-control"  type="number" name="max_co2" id="max_co2" required>
                             
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>  
              </div>
            </div>
        </div>
      </div>
    </div>

    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/node_modules/pace-progress/pace.min.js"></script>
    <script src="/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="/node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="/node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
    <!-- <script src="/js/main.js"></script> -->
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
    <script>

  function Setting(){
        var api_url = "/devicesetting";

        $.ajax({
          url: api_url,
          success: function(responseData) {
              document.getElementById("max_temperature").value = responseData.device.max_temperature;
              document.getElementById("max_co2").value = responseData.device.max_co2;
              
          }
        });
      }

      function openSetting(){
        Setting();
          $('#ss_overlay').modal('show');
      }
      </script>
  </body>
</html>
