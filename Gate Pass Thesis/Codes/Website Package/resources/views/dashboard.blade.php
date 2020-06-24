@extends('layouts.coreuiadmin')

@section('title')
Dashboard ICu Environment
@endsection

@section('bodyTitle')
Dashboard
@endsection

@section('customCSS')
<style>
    .brand-card-header{
        background-color:#5c6873;
        height: 50px;
    }
</style>
@endsection
<style type="text/css">
</style>
@section('content')
<div class="row justify-content-md-center">
    <div class="col-sm-12 col-xl-4">
    <!-- <img style="height:40vh; width:100%" style="-webkit-user-select: none;" id="camera"> -->
        <!-- <iframe  style="height:40vh; width:100%" id="camera"></iframe> -->
        <div class="card"> 
            <div class="card-header">
                <i class="nav-icon fa fa-camera"></i> Camera
            </div>
            <div id="camera-body" class="card-body"  style="padding:5px">
                 <img style=" width: 100%; object-fit: contain;display: block;margin-left: auto; margin-right: auto;" id="camera" />
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-4">
            <div class="card"> 
                <div class="card-header">
                    <i class="nav-icon fa fa-file-image-o"></i> AI Detected Plate Number
                </div>
                <div  class="card-body"  style="padding:5px">
                    <div style="text-align: center;" id="mainPlate">
                    <h4 ><span id="detectedPlate">No Plate Detected</span></h4>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-sm-12 col-xl-4">
            <div class="card"> 
                <div class="card-header">
                    <i class="nav-icon fa fa-file-image-o"></i> Last Image Taken
                </div>
                <div id="img-body"  class="card-body"  style="padding:5px">
                    <img  id="lastImage" style="width: 100%; background: #0e0e0e; object-fit: contain;display: block;margin-left: auto; margin-right: auto;" src="/img/plate/1.jpg" >
                </div>
            </div>
    </div>
  
        <div class="col-sm-6 col-lg-3">
            <div class="card">
            <div class="brand-card-header">
                <i class="fa fa-file-text"></i>
            </div>
            <div class="brand-card-body">
                <div>
                <div id="totalIn" class="text-value">0</div>
                <div class="text-uppercase text-muted small">No. of Total User Log Inside</div>
                </div>
                <div>
                <div id="totalOut" class="text-value">0</div>
                <div class="text-uppercase text-muted small">No. of Total User Log Outside</div>
                </div>
            </div>
            </div>
        </div><!--/.col-->
        <div class="col-sm-8 col-lg-6 ">
            <div class="brand-card">
            <div class="brand-card-header">
                <i class="fa fa-file-text"></i>
            </div>
            <div id="sameHieght" class="brand-card-body">
                <div>
                <div style="font-weight:bold;">User Type:</div>
                <div id="inUser">Owner</div>
                <div style="font-weight:bold;">Name:</div>
                <div id="inName">Test Account 101</div>
                <div  style="font-weight:bold;">RFID No.:</div>
                <div id="inRfid">0866498629</div>
                <div style="font-weight:bold;">Plate No.: </div>
                <div id="inPlate">TY 8738</div>
                <div style="font-weight:bold;">Address:</div>
                <div id="inAddress" >Test Place, Block 10 Lot 1</div>
                <div style="font-weight:bold;">Time:</div>
                <div id="inTime" >2018-07-11 16:00:46</div>
                <div class="text-uppercase text-muted small">Last User Log In</div>
                </div>
                <div>
                <div style="font-weight:bold;">User Type:</div>
                <div id="outUser">Owner</div>
                <div style="font-weight:bold;">Name:</div>
                <div id="outName">Test Account 101</div>
                <div  style="font-weight:bold;">RFID No.:</div>
                <div id="outRfid">0866498629</div>
                <div style="font-weight:bold;">Plate No.: </div>
                <div id="outPlate">TY 8738</div>
                <div style="font-weight:bold;">Address:</div>
                <div id="outAddress" >Test Place, Block 10 Lot 1</div>
                <div style="font-weight:bold;">Time:</div>
                <div id="outTime" >2018-07-11 16:00:46</div>
                <div class="text-uppercase text-muted small">Last User Log Out</div>
                </div>
            </div>
            </div>
        </div><!--/.col-->
        <div class="col-sm-6 col-lg-3">
            <div class="brand-card">
            <div class="brand-card-header">
                <i class="fa fa-file-text"></i>
            </div>
            <div class="brand-card-body">
                <div>
                <div id="curIn" class="text-value">0</div>
                <div class="text-uppercase text-muted small">No. of User Log Inside</div>
                </div>
                <div>
                <div id="curOut" class="text-value">0</div>
                <div class="text-uppercase text-muted small">No. of User Log Outside</div>
                </div>
            </div>
            </div>
        </div><!--/.col-->
</div><!--/.row-->

@endsection

@section('customScript')
<script>
 var currentDate = formatDate();
 var windowLocation = "";
 var updatedAt;
$(function() { 
        windowLocation = "/cameraalone"//window.location.protocol + "//" + window.location.hostname + ":8081/";
        document.getElementById('camera').src = windowLocation; 
        setInterval(function(){ getPlate() }, 2000);

        requestLog();
        requestReport();
        setInterval(function(){ requestLog() }, 2000);
        setInterval(function(){ requestReport() }, 2000);
        var clientHeight = document.getElementById('sameHieght').clientHeight - 100;
        // console.log(clientHeight);
        document.getElementById('camera').style.height = clientHeight;
        document.getElementById('lastImage').style.height = clientHeight;
       // document.getElementById('lastAiImage').style.height = clientHeight-33;
        document.getElementById('detectedPlate').style.height = clientHeight;
  
        
        
});

function getPlate(){
        $.ajax({url: "/getplate", success: function(responseData){
            // console.log(responseData.plate_detected.updated_at);
            if(updatedAt != responseData.plate_detected.updated_at){
                updatedAt = responseData.plate_detected.updated_at;
                var plateNumber = responseData.plate_detected.plate_number.slice(0, -1);
                if (plateNumber == ""){
                    document.getElementById('detectedPlate').innerHTML = "Unable To decode Plate Number";
                }else{
                    document.getElementById('detectedPlate').innerHTML = plateNumber;
                }
                
                testConnection();
            }
             
        }});
}

  function testConnection(){
        document.getElementById('lastImage').src = "/img/plate/1.jpg?" + new Date().getTime();
        // document.getElementById('lastAiImage').src = "/img/croplate/imgCropPlateScene.png?" + new Date().getTime();
        console.log("changing image");   
  }

function formatDate(){
    var date = new Date();
    var nyear = date.getFullYear();
    var nmonth = ((date.getMonth()+1).toString().length == 2 ? (date.getMonth()+1) : "0"+(date.getMonth()+1));
    var nday = ((date.getDate()).toString().length == 2 ? (date.getDate()) : "0"+(date.getDate()));
    var retrunDate =  nyear + "-" + nmonth + "-" + nday;
    
   // console.log(retrunDate);
    
    return retrunDate;
}
function requestLog(){
    var inUser = document.getElementById("inUser");
    var inName = document.getElementById("inName");
    var inRfid = document.getElementById("inRfid");
    var inPlate = document.getElementById("inPlate");
    var inAddress = document.getElementById("inAddress");
    var inTime = document.getElementById("inTime");

    var outUser = document.getElementById("outUser");
    var outName = document.getElementById("outName");
    var outRfid = document.getElementById("outRfid");
    var outPlate = document.getElementById("outPlate");
    var outAddress = document.getElementById("outAddress");
    var outTime = document.getElementById("outTime");
  
    var Mainurl = "/currentlog";
    $.ajax({url: Mainurl, success: function(responseData){
        var user_type_in = (responseData.rfiduserin.user_type == null) ? 'Unregistered':responseData.rfiduserin.user_type;
         inUser.innerHTML =user_type_in;
         var account_name_in = (responseData.rfiduserin.account_name == null) ? 'Unregistered':responseData.rfiduserin.account_name;
         inName.innerHTML =account_name_in;
         inRfid.innerHTML =responseData.rfiduserin.rfid_no;
         var plate_no_in = (responseData.rfiduserin.plate_no == null) ? 'Unregistered':responseData.rfiduserin.plate_no;
         inPlate.innerHTML =plate_no_in;
         var house_address_in = (responseData.rfiduserin.house_address == null) ? 'Unregistered':responseData.rfiduserin.house_address;
         inAddress.innerHTML =house_address_in;
         inTime.innerHTML =responseData.rfiduserin.created_at;

        var user_type_out = (responseData.rfiduserout.user_type == null) ? 'Unregistered':responseData.rfiduserout.user_type;
        outUser.innerHTML =user_type_out;
        var account_name_out = (responseData.rfiduserout.account_name == null) ? 'Unregistered':responseData.rfiduserout.account_name;
         outName.innerHTML =account_name_out;
         outRfid.innerHTML =responseData.rfiduserout.rfid_no;
         var plate_no_out = (responseData.rfiduserout.plate_no == null) ? 'Unregistered':responseData.rfiduserout.plate_no;
         outPlate.innerHTML =plate_no_out;
         var house_address_out = (responseData.rfiduserout.house_address == null) ? 'Unregistered':responseData.rfiduserout.house_address;
         outAddress.innerHTML =house_address_out;
         outTime.innerHTML =responseData.rfiduserout.created_at;
    }});
}
function requestReport(){
    var curIn = [];
    var curOut = [];
    var indexIn = 0;
    var indexOut = 0;
    $.ajax({url: "/countinout/"+currentDate, success: function(responseData){

        $.each(responseData.rfidcurinout, function(i, item) {
            if(item.curstate == 1){
            curIn[indexIn] = item.curstate;
            indexIn++;
            }else{
            curOut[indexOut] = item.curstate;
            indexOut++;
            }
        
        });  
        document.getElementById('totalIn').innerHTML = responseData.rfidin.total_in;
        document.getElementById('totalOut').innerHTML = responseData.rfidout.total_out;
        document.getElementById('curIn').innerHTML = curIn.length;
        document.getElementById('curOut').innerHTML = curOut.length;
        // console.log("Total In: "+ responseData.rfidin.total_in);
        // console.log("Total Out: "+ responseData.rfidout.total_out);
        // console.log("curIn: "+ curIn.length);
        // console.log("curOut: "+ curOut.length);                  
    }});
}
</script>
@endSection
