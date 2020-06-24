@extends('layouts.coreuiadmin')

@section('title')
Dashboard Face Recognition
@endsection

@section('bodyTitle')
Dashboard
@endsection

@section('customCSS')
@endsection
<style type="text/css">
 .table .thead-dark th {
    color: #e4e5e6;
    background-color: #23282c;
    border-color: #343b41;
    font-size: 12px;
}

 tbody {
    display:block;
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
    min-width:300px;
  }

  .table th, .table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #c8ced3;
    font-size: 12;
}
</style>
@section('content')
@section('content')
<div class="row justify-content-md-center">
    <div class="col-sm-12 col-xl-4">
        <div class="card"> 
            <div class="card-header">
                <i class="nav-icon fa fa-folder-open"></i> Current Log Counter
            </div>
            <div  class="card-body" id="sameHieght" style="padding:5px">
                <div class="card">
                <div class="brand-card-body">
                    <div>
                    <div id="totalIn" class="text-value">0</div>
                    <div class="text-uppercase text-muted small">Total Student Log Inside</div>
                    </div>
                    <div>
                    <div id="totalOut" class="text-value">0</div>
                    <div class="text-uppercase text-muted small">Total Student Log Outside</div>
                    </div>
                </div>
                </div>
                <div class="brand-card">
                <div class="brand-card-body">
                    <div>
                    <div id="curIn" class="text-value">0</div>
                    <div class="text-uppercase text-muted small">Student Log Inside</div>
                    </div>
                    <div>
                    <div id="curOut" class="text-value">0</div>
                    <div class="text-uppercase text-muted small">Student Log Outside</div>
                    </div>
                </div>
                </div>
            </div>
            <div class="card-footer clearfix" style="background-color: white">
                <div style="float: left;">Date: <span id="date1"><span></div>
				<a class="pull-right" href="/report">More</a>
			</div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-4">
            <div class="card"> 
                <div class="card-header">
                    <i class="nav-icon fa fa-history"></i> Last Log
                </div>
                <div  class="card-body"  style="padding:5px">
                <div class="brand-card">
            <div id="sameHieght" class="brand-card-body">
                <div>
                <div style="font-weight:bold;">Name:</div>
                <div id="inName">None</div>
                <div  style="font-weight:bold;">DOB:</div>
                <div id="inDob">None</div>
                <div style="font-weight:bold;">Guardian No.: </div>
                <div id="inGuardian">None</div>
                <div style="font-weight:bold;">Address:</div>
                <div id="inAddress" >None</div>
                <div style="font-weight:bold;">Time:</div>
                <div id="inTime" >None</div>
                <div class="text-uppercase text-muted small">Last Student Log In</div>
                </div>
                <div>
                <div style="font-weight:bold;">Name:</div>
                <div id="outName">None</div>
                <div  style="font-weight:bold;">DOB:</div>
                <div id="outDob">None</div>
                <div style="font-weight:bold;">Guardian No.: </div>
                <div id="outGuardian">None</div>
                <div style="font-weight:bold;">Address:</div>
                <div id="outAddress" >None</div>
                <div style="font-weight:bold;">Time:</div>
                <div id="outTime" >None</div>
                <div class="text-uppercase text-muted small">Last Student Log Out</div>
                </div>
            </div>
            </div>
                </div>
            </div>
    </div>
    <div class="col-sm-12 col-xl-4">
            <div class="card"> 
                <div class="card-header">
                    <i class="nav-icon fa fa-envelope"></i> Current Sent Messages
                </div>
                <div  class="card-body" id='h_table' style="padding:0px; margin:0;">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name
                                    </th>
                                    <th scope="col">Sent
                                    </th>
                                    <th scope="col">Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody" width="100%" >
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix" style="background-color: white">
                <div style="float: left;">Date: <span id="date2"><span></div>
				<a class="pull-right" href="/smslogs">More</a>
			</div>
            </div>
    </div>

    <div class="col-sm-12 col-xl-12">
            <div class="card"> 
                <div class="card-header">
                    <i class="nav-icon fa fa-history"></i> Current Student Logs
                </div>
                <div  class="card-body" id='h_table' style="padding:0px; margin:0;">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name
                                    </th>
                                    <th scope="col">Grade Level
                                    </th>
                                    <th scope="col">Section
                                    </th>
                                    <th scope="col">DOB
                                    </th>
                                    <th scope="col">Gurdian No.
                                    </th>
                                    <th scope="col">Address
                                    </th>
                                    <th scope="col">Status
                                    </th>
                                    <th scope="col">Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody2" width="100%" >
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix" style="background-color: white">
                <div style="float: left;">Date: <span id="date3"><span></div>
				<a class="pull-right" href="/studentlogs">More</a>
			</div>
            </div>
    </div>
</div><!--/.row-->
@endsection

@section('customScript')
<script type="text/javascript">
    var currentDate = formatDate();
    var startdate;
    var enddate;
    var latestId = 0;

    $(function() {
        document.getElementById('date1').innerHTML = currentDate;
        document.getElementById('date2').innerHTML = currentDate;
        document.getElementById('date3').innerHTML = currentDate;
        var clientHeight = document.getElementById('sameHieght').clientHeight ;
        document.getElementById('tbody').style.height = clientHeight - 52;
        document.getElementById('tbody2').style.height = clientHeight;
        
        console.log(clientHeight);
        requestLog();
        setInterval(function(){ requestLog() }, 2000);

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
    }});
}

function requestLog(){
    var inName = document.getElementById("inName");
    var inDob = document.getElementById("inDob");
    var inGuardian = document.getElementById("inGuardian");
    var inAddress = document.getElementById("inAddress");
    var inTime = document.getElementById("inTime");

    var outName = document.getElementById("outName");
    var outDob = document.getElementById("outDob");
    var outGuardian = document.getElementById("outGuardian");
    var outAddress = document.getElementById("outAddress");
    var outTime = document.getElementById("outTime");
  
    var Mainurl = "/currentlog";
    $.ajax({url: Mainurl, success: function(responseData){
         inName.innerHTML =responseData.studentin.name;
         inDob.innerHTML =responseData.studentin.dob;
         inGuardian.innerHTML =responseData.studentin.mobile_numer;
         inAddress.innerHTML =responseData.studentin.address;
         inDob.innerHTML =responseData.studentin.created_at;

         outName.innerHTML =responseData.studentinout.name;
         outDob.innerHTML =responseData.studentinout.dob;
         outGuardian.innerHTML =responseData.studentinout.mobile_numer;
         outAddress.innerHTML =responseData.studentinout.address;
         outTime.innerHTML =responseData.studentinout.created_at;
         if(responseData.studentin.id > latestId || responseData.studentinout.id  > latestId){
             if (responseData.studentin.id  > responseData.studentinout.id ){
                latestId = responseData.studentin.id 
             }else{
                latestId = responseData.studentinout.id 
             }
            console.log("Sending Request");
            requestReport();
            firstReadFromDatabase();
            sendRequest2(currentDate);
         }
    }});
}

  function firstReadFromDatabase() {
    var requestDate = getCurrentDate();
    sendRequest(requestDate)
  }
  
  function getCurrentDate() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();

    if (dd < 10) {
      dd = '0' + dd
    }

    if (mm < 10) {
       mm = '0' + mm
    }
    today = yyyy + '-' + mm + '-' + dd;
    return today;
  }

  function sendRequest(requestDate) {
    currentDate = requestDate;

    var startdate = requestDate + " 00:00:00";
    var enddate = requestDate + " 23:59:00";
    var rows= "";

    var api_url = "selectsmslogs/"+startdate + "/" + enddate;

    $.ajax({
      url: api_url,
      success: function(responseData) {
      $.each(responseData.records, function(i, item) {
        rows += "<tr>"
        rows += "<td>" + item.name + "</td>";
        var status = "Sent";
        if (item.sent == 1){
          status = "Sent";
        }else{
          status = "Failed";
        }
        rows += "<td>" + status + "</td>";
        rows += "<td>" + item.created_at + "</td>";
        rows += "</tr>"
      });

      document.getElementById('tbody').innerHTML = '';
      $('#tbody').append(rows);

      }
    });
  }

    function sendRequest2(requestDate) {
    currentDate = requestDate;

    startdate = requestDate + " 00:00:00";
    enddate = requestDate + " 23:59:00";
    var rows= "";

    var api_url = "selectlogs/"+startdate + "/" + enddate;

    $.ajax({
      url: api_url,
      success: function(responseData) {
      $.each(responseData.records, function(i, item) {
        rows += "<tr>"
        rows += "<td>" + item.name + "</td>";
        rows += "<td>" + item.grade_level + "</td>";
        rows += "<td>" + item.section + "</td>";
        rows += "<td>" + item.dob + "</td>";
        rows += "<td>" + item.mobile_numer + "</td>";
        rows += "<td>" + item.address + "</td>";
        var status = "In";
        if (item.status == 1){
          status = "In";
        }else if (item.status == 0){
          status = "Out";
        }else{
            status = "Unknown";
        }
        rows += "<td>" + status + "</td>";
        rows += "<td>" + item.created_at + "</td>";
        rows += "</tr>"
      });

      document.getElementById('tbody2').innerHTML = '';
      $('#tbody2').append(rows);

      }
    });
  }
</script>
@endSection
