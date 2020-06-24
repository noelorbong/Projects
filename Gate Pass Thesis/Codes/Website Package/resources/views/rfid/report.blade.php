@extends('layouts.coreuiadmin')

@section('title')
Report RFID
@endsection

@section('bodyTitle')
Report
@endsection

@section('customCSS')
<style>
    .brand-card-header{
        background-color:#5c6873;
    }
 
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-folder-open"></i> Report
    <span class="pull-right">Date: <input id="selectDate" type="date"   onchange="handler(event);" required></span>
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <div class="row">
        <div class="col-sm-6 col-lg-6">
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
        <div class="col-sm-6 col-lg-6">
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
  </div>
  
</div>
@endsection

@section('customScript')
<script>
$(function() { 
    var currentDate = formatDate();
    document.getElementById("selectDate").value = currentDate;
    requestData(currentDate)
});

function formatDate(){
    var date = new Date();
    var nyear = date.getFullYear();
    var nmonth = ((date.getMonth()+1).toString().length == 2 ? (date.getMonth()+1) : "0"+(date.getMonth()+1));
    var nday = ((date.getDate()).toString().length == 2 ? (date.getDate()) : "0"+(date.getDate()));
    var retrunDate =  nyear + "-" + nmonth + "-" + nday;
    
    console.log(retrunDate);
    
    return retrunDate;
}

function handler(e){
    var date = e.target.value;
    requestData(date);
  }

function requestData(date){

  var curIn = [];
  var curOut = [];
  var indexIn = 0;
  var indexOut = 0;
  $.ajax({url: "/countinout/"+date, success: function(responseData){

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
      console.log("Total In: "+ responseData.rfidin.total_in);
      console.log("Total Out: "+ responseData.rfidout.total_out);
      console.log("curIn: "+ curIn.length);
      console.log("curOut: "+ curOut.length);                  
  }});

}
</script>
@endSection
