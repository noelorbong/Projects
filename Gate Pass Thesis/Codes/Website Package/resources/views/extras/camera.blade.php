@extends('layouts.coreuiadmin')

@section('title')
Camera Gate Pass
@endsection

@section('bodyTitle')
Camera
@endsection

@section('customCSS')
<style type="text/css">
	.camera{
		height:70vh; 
		width:100%;
	}
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
  <i class="nav-icon fa fa-camera"></i> Camera Admin
  <span class="pull-right">
    <div class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" id="ipAddress" name="ipAddress" placeholder="IP Address" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" id="changeIp" >Change</button>
    </div>
 </span>
  </div>
  <div class="card-body" style="padding:0; margin:0;">
    <iframe  id="camera" class="camera" ></iframe>
  </div>
</div>
<div class="card">
  <div class="card-header">
  <i class="nav-icon fa fa-camera"></i> Camera Admin
  </div>
  <div class="card-body" style="padding:0; margin:0;">
  </div>
</div>
@endsection

@section('customScript')
<script type="text/javascript">

    var windowLocation = "";
    document.getElementById("changeIp").addEventListener("click", changeIp);
    $(function() {
        //windowLocation = "http://10.238.208.10/web/admin.html"//"/cameraalone"//window.location.protocol + "//" + window.location.hostname + ":8081/";
        document.getElementById('camera').src = windowLocation; 
        getIp();
    });

    function getIp(){
        $.ajax({url: "/getip", success: function(responseData){
            console.log(responseData.ip_camera.ip_address);
            document.getElementById("ipAddress").value =  responseData.ip_camera.ip_address; 
            windowLocation = "http://"+responseData.ip_camera.ip_address+"/web/admin.html"
            document.getElementById('camera').src = windowLocation;              
        }});
    }

    function changeIp(){
        var newIp = document.getElementById("ipAddress").value;
        $.ajax({url: "/updatecam/"+newIp, success: function(responseData){
            console.log(newIp); 
            windowLocation = "http://"+newIp+"/web/admin.html"
            document.getElementById('camera').src = windowLocation;              
        }});
    }
    
   
</script>
@endSection
