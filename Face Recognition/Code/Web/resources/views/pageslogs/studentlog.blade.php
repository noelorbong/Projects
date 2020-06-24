@extends('layouts.coreuiadmin')

@section('title')
Student Logs
@endsection

@section('bodyTitle')
Student Logs
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
    <i class="nav-icon fa fa-list-alt"></i> Student Logs 
  </div>
  <div class="card-body" style="padding:0px; margin:0;">
    <div class="table-responsive">
      <table class="table text-center">
          <thead class="thead-dark">
              <tr>
                <th scope="col">Name
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
          <tbody id="tbody" width="100%" height="40vh">
          </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer text-muted">
      Date: <input id="selectDate" onchange="pickDate(event);" type="date" required>
      <button onclick="printData()" class="btn btn-primary" style="float:right; margin-left:10px;"><i class="nav-icon fa fa-clipboard"> </i> Print</button>
      <button onclick="confirmEmail()" class="btn btn-primary" style="float:right;"><i class="nav-icon fa fa-envelope"> </i> Email</button>
  </div>
</div>

<div class="modal fade" id="overlay" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="background: transparent; border-color: transparent;">
        <div class="modal-body" >
            <div class="card">
                <div class="card-header">
                    <i class="nav-icon fa fa-envelope"></i>Send Email
                    <button style="float:right" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="card-body" style="padding:30px; margin:0;">
                    <div>
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Recepient Email</label>
                            <input type="email" class="form-control" name="receipient" id="ee_recipient" placeholder="e.g. ireceivedemail@gmail.com" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Log Date</label>
                            <input type="date"  onchange="pickDate(event);"  class="form-control" name="date" id="e_date"  required>
                        </div>
                        <button onclick="sendEmail()" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
                
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="overlay2">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
            <p class="btn btn-success">Success</p>
        </div>
    </div>
</div>
<div class="modal fade" id="overlay3">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
            <p class="btn btn-warning">Failed.. Recipient needed</p>
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script>
  var currentDate;
  var startdate;
  var enddate;

  $(function() {
      firstReadFromDatabase();
  });

  function s_showModal() {
        $('#overlay2').modal('show');

        setTimeout(function() {
            $('#overlay2').modal('hide');
            $('#overlay').modal('hide');
           
        }, 1500);
  }

  function f_showModal() {
        $('#overlay3').modal('show');

        setTimeout(function() {
            $('#overlay3').modal('hide');
            $('#overlay').modal('hide');
           
        }, 2000);
  }

  function printData() {
    window.location.href = "/print/" +startdate + "/" + enddate;
  }

  function confirmEmail() {
    $('#overlay').modal('show');
  }

  function sendEmail() {
        var e_date = document.getElementById("e_date");
        var e_recipient = document.getElementById("ee_recipient");
        var _token = document.getElementsByName("_token")[0];
        console.log(_token.value);
        if (!e_recipient.value){
          f_showModal()
          return
        }
        $.ajax({
            type: "POST",
            url: "/emailstore",
            data: {receipient: e_recipient.value,
                    date: e_date.value,
                    _token:_token.value
                    },
            success: function(responseData) {
                    s_showModal();
                    console.log(responseData)
            }
        });
    }

  function firstReadFromDatabase() {
    var requestDate = getCurrentDate();
    document.getElementById("selectDate").value = requestDate;
    document.getElementById("e_date").value = requestDate;
    sendRequest(requestDate)
  }

  function pickDate(e) {
    document.getElementById("selectDate").value = e.target.value;
    document.getElementById("e_date").value = e.target.value;
    sendRequest(e.target.value);
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

    startdate = requestDate + " 00:00:00";
    enddate = requestDate + " 23:59:00";
    rows= "";

    var api_url = "selectlogs/"+startdate + "/" + enddate;

    $.ajax({
      url: api_url,
      success: function(responseData) {
      $.each(responseData.records, function(i, item) {
        rows += "<tr>"
        rows += "<td>" + item.name + "</td>";
        rows += "<td>" + item.dob + "</td>";
        rows += "<td>" + item.mobile_numer + "</td>";
        rows += "<td>" + item.address + "</td>";
        var status = "In";
        if (item.status == 1){
          status = "In";
        }else{
          status = "Out";
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