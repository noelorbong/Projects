@extends('layouts.coreuiadmin')

@section('title')
SMS Logs
@endsection

@section('bodyTitle')
SMS Logs
@endsection

@section('customCSS')
<style>
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
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-list-alt"></i> SMS Logs
  </div>
  <div class="card-body" style="padding:0px; margin:0;">
    <div class="table-responsive">
      <table class="table text-center">
          <thead class="thead-dark">
              <tr>
                <th scope="col">Name
                </th>
                <th scope="col">Message
                </th>
                <th scope="col">Gurdian No.
                </th>
                <th scope="col">Sent
                </th>
                <th scope="col">Date
                </th>
              </tr>
          </thead>
          <tbody id="tbody" width="100%" height="40vh">
          </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer text-muted">
  Start Date: <input id="startSelectDate" type="date" required>
      End Date: <input id="endSelectDate"  type="date" required>
      <button onclick="pickDate()" class="btn btn-primary" ><i class="nav-icon fa fa-hand-o-right "> </i> Pick</button>
  </div>
</div>
@endsection

@section('customScript')
<script>
  var currentDate;

  $(function() {
      firstReadFromDatabase();
  });

  function firstReadFromDatabase() {
    var requestDate = getCurrentDate();
    document.getElementById("startSelectDate").value = requestDate;
    document.getElementById("endSelectDate").value = requestDate;
    startDate = requestDate;
    endDate =  requestDate;
    sendRequest(requestDate,requestDate)
  }

  function pickDate() {
    startDate = document.getElementById("startSelectDate").value;
    endDate = document.getElementById("endSelectDate").value;
    sendRequest(startDate,endDate);
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

  function sendRequest(startdate,enddate) {
    // currentDate = requestDate;

    // var startdate = requestDate + " 00:00:00";
    // var enddate = requestDate + " 23:59:00";
    var rows= "";

    var api_url = "selectsmslogs/"+startdate + "/" + enddate;

    $.ajax({
      url: api_url,
      success: function(responseData) {
      $.each(responseData.records, function(i, item) {
        rows += "<tr>"
        rows += "<td>" + item.name + "</td>";
        rows += "<td>" + item.message + "</td>";
        rows += "<td>" + item.number + "</td>";
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
</script>
@endSection