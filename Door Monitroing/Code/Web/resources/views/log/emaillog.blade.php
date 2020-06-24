@extends('layouts.coreuiadmin')

@section('title')
List Email Log
@endsection

@section('bodyTitle')
Email Log |List
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
  .modal {
    text-align: center;
  }

@media screen and (min-width: 768px) { 
  .modal:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
  }
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-list-alt"></i> Email Log List 
  </div>
  <div class="card-body" style="padding:0px; margin:0;">
    <div class="table-responsive">
      <table class="table text-center">
          <thead class="thead-dark">
              <tr>
                <th scope="col">Name
                </th>
                <th scope="col">Email
                </th>
                <th scope="col">Subject
                </th>
                <th scope="col">Sent
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
      Date: <input id="selectDate" onchange="pickDate(event);" type="date" required>
      &nbsp; &nbsp; No. Of Record: <span id="recordHolder"> 0<span>
  </div>
</div>
@endsection

@section('customScript')
<script>
  var currentDate;

    $(function() {
        firstReadFromDatabase();
    });

  function pickDate(e) {
    sendRequest(e.target.value);
  }

 function firstReadFromDatabase() {
    var requestDate = getCurrentDate();
    document.getElementById("selectDate").value = requestDate;
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
    rows= "";

    var api_url = "selectemaillog/"+startdate + "/" + enddate;

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
        rows += "<td>" + item.name + "</td>";
        rows += "<td>" + item.email + "</td>";
        rows += "<td>" + item.subject + "</td>";
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
