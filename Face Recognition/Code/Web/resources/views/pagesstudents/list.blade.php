@extends('layouts.coreuiadmin')

@section('title')
List Students
@endsection

@section('bodyTitle')
Students|List
@endsection

@section('customCSS')
<style>
  tbody {
    display:block;
    height:59vh;
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
    <i class="nav-icon fa fa-list-alt"></i> Student List 
    <span class="pull-right">
    <div class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" id="search" name="search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" id="searchbtn" onclick="sortData('','', true)">Search</button>
    </div>
    </span>
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
                <th scope="col">Date
                </th>
                <th scope="col">Manage</th>
              </tr>
          </thead>
          <tbody id="tbody">
          </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="overlay">
  <div class="modal-dialog">
    <div class="modal-content" style="border-color: transparent; background-color: transparent; text-align: -webkit-center;">
      <h3 style="color: white;" id="procName">Checking...</h3>
      <img src="/img/ajax-loader.gif" style="width: 200px; height: 200px;"></img>
    </div>
  </div>
</div>
@endsection

@section('customScript')
<script>
  $(function() {
    $('#overlay').modal({
              backdrop: 'static',
              keyboard: false 
           });
      sortData("name","ASC", false)
      checkProcess()
      setInterval(function() {
        checkProcess()
      }, 1000);
  });

  function checkProcess(){
    var main_url = '/regcount';
    // console.log(main_url);
  
    $.ajax({url: main_url, success: function(responseData){
      // console.log(responseData.count);
        if (responseData.count != 0){
          $('#overlay').modal('show');
          document.getElementById('procName').innerHTML = "Processing "+responseData.student.name+" Face Registration";
        }else{
          $('#overlay').modal('hide');
        }
     }});
  }

  function faceRegister(context,unique_id){
    var main_url = '/takecamera/'+unique_id
    $.ajax({url: main_url, success: function(responseData){
       console.log(responseData);
      //  $(context).closest('button').remove();
      $(context).closest('button').text("Reregister");
      $(context).closest('button').css({"background-color": "#ffc107", "border-color": "#ffc107"});
     }});


  }

  function sortData(sortcolum,sort, isSearch){
    var rows ="";
    var main_url = ''
    var search = document.getElementById("search").value.trim();
    if(isSearch){
      main_url = 'searchstudents/'+search
    }else{
      main_url = 'sortstudents/'+sortcolum+'/'+sort
    }

    console.log(main_url);
  
      $.ajax({url: main_url, success: function(responseData){
          $.each(responseData.studentlist, function(i, item) {
            rows += "<tr >"
            rows +=  "<td style='cursor:pointer' class='clickable-row' data-href='profile/" + item.id + "'>"+item.name+"</td>";
            rows +=  "<td style='cursor:pointer' class='clickable-row' data-href='profile/" + item.id + "'>"+item.dob+"</td>";
            rows +=  "<td style='cursor:pointer' class='clickable-row' data-href='profile/" + item.id + "'>"+item.mobile_number+"</td>";
            rows +=  "<td style='cursor:pointer' class='clickable-row' data-href='profile/" + item.id + "'>"+item.address+"</td>";
            rows +=  "<td style='cursor:pointer' class='clickable-row' data-href='profile/" + item.id + "'>"+item.created_at+"</td>";
            rows += "<td>\
                      <div class=\"text-center\" style=\"background-color: white\">\
                        <a class=\"btn btn-primary btn-sm\" href=\"/edit/"+item.id+"\"> Edit</a>"
            if (item.registered == 0){
              rows += " <button class=\"btn btn-success btn-sm\"  onclick=\"faceRegister(this, "+item.id+")\" > Register</button>"
            }else{
              rows += " <button class=\"btn btn-warning btn-sm\"  onclick=\"faceRegister(this, "+item.id+")\" > Reregister</button>"
            }
           
            rows += "</div> </td>"
                  
            rows += "</tr>"
          });  

          document.getElementById('tbody').innerHTML = '';
          $('#tbody').append(rows);  

           $(".clickable-row").click(function() {
              window.location = $(this).data("href");
          });        
      }});

  }
</script>
@endSection
