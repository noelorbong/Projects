@extends('layouts.coreuiadmin')

@section('title')
Messages
@endsection

@section('bodyTitle')
Messages
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
    <i class="nav-icon fa fa-list-alt"></i> Pending Messages 
    <!-- <button  class="btn btn-primary btn-sm" style="float:right"><i class="nav-icon fa fa-gear"> </i> Setting</button> -->
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
                <th scope="col">Date
                </th>
              </tr>
          </thead>
          <tbody id="tbody" width="100%" height="40vh">
          </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('customScript')
<script>
  var currentDate;

  $(function() {
    sendRequest();
  });

  function sendRequest() {
    var rows= "";
    var api_url = "smslist";

    $.ajax({
      url: api_url,
      success: function(responseData) {
      $.each(responseData.messages, function(i, item) {
        rows += "<tr>"
        rows += "<td>" + item.name + "</td>";
        rows += "<td>" + item.message + "</td>";
        rows += "<td>" + item.mobile_number + "</td>";
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