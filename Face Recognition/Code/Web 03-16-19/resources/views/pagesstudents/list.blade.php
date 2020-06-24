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
  
/* .modal {
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
} */

.m-row {
    display: -ms-flexbox; /* IE10 */
    display: flex;
    -ms-flex-wrap: wrap; /* IE10 */
    flex-wrap: wrap;
    padding: 0 4px;
}

/* Create four equal columns that sits next to each other */
.m-column {
    -ms-flex: 25%; /* IE10 */
    flex: 25%;
    max-width: 25%;
    padding: 0 4px;
}

.m-column img {
    margin-top: 8px;
    vertical-align: middle;
}

/* Responsive layout - makes a two column-layout instead of four columns */
@media screen and (max-width: 800px) {
    .m-column {
        -ms-flex: 50%;
        flex: 50%;
        max-width: 50%;
    }
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
    .m-column {
        -ms-flex: 100%;
        flex: 100%;
        max-width: 100%;
    }
}

.info-div {
  /* position: absolute; */
  width: 100%;
  /* margin-top: -100px; */
  z-index: 10;
  height: 100%;
  max-height: 1340px;
  overflow-y: scroll;
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

<div class="modal fade" id="captured_images">
  <div class="modal-dialog">
    <div class="modal-content" >
        <div class="card">
          <div class="card-header">
          <i class="nav-icon fa fa-picture-o"></i>Captured Images
          </div>
          <div class="card-body" style="margin:0px; padding:0px; height:50vh">
            <div class="info-div" id="card_body">
            </div>
          </div>
        </div>
        <button style="margin:5px;"  id="c_image" onclick="confirmImage()" class="btn btn-primary"> Confirm</button>
        <button style="color:white; margin:5px;"  id="r_image" onclick="reRegister()" class="btn btn-warning"> Reregiter</button>
    </div>
  </div>
</div>

<div class="modal fade" id="overlay">
  <div class="modal-dialog">
    <div class="modal-content" style="border-color: transparent; background-color: transparent; text-align: -webkit-center;">
      
      <img src="/img/ajax-loader.gif" style="margin-top:20%; width: 200px; height: 200px;" />
      <h3 style="color: white; background-color: rgba(10, 10, 10, 0.7);" id="procName">Checking...</h3>
      <!-- <button class="btn btn-success btn-sm"  style="margin-top: 5px;" onclick="confirmImage()" > Cancel</button> -->
    </div>
  </div>
</div>

<div class="modal fade" id="overlay_succes">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
            <p class="btn btn-success">Success</p>
        </div>
    </div>
</div>

@endsection

@section('customScript')
<script>
  var d_time = new Date().toLocaleString();
  var lastStatus= 800;
  $(function() {
    console.log(d_time);
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

  function showModal() {
    $('#overlay_succes').modal('show');

    setTimeout(function() {
      $('#overlay_succes').modal('hide');
    }, 500);
  }

  function checkProcess(){
    var main_url = '/regcount';
    // console.log(main_url);
  
    $.ajax({url: main_url, success: function(responseData){
      
      if(responseData.r_student){
      }else{$('#overlay').modal('hide');
        return;}

      var status = responseData.r_student.status;
      console.log(status);
      if (lastStatus != status){
        // lastStatus = status;
        if (status == 0){
          document.getElementById("c_image").style.display = "none";
          document.getElementById("r_image").style.display = "none";
          $('#captured_images').modal('hide');
          $('#overlay').modal('show');
          document.getElementById('procName').innerHTML = "Capturing "+responseData.student.name+" Face";
        }else if (status == 1){
          document.getElementById("c_image").style.display = "none";
          document.getElementById("r_image").style.display = "none";
          $('#overlay').modal('show');
          $('#captured_images').modal('show');
          showImages(responseData.r_student.face_id)
          document.getElementById('procName').innerHTML = "Traning "+responseData.student.name+" Face";
        }else if (status == 2){
          document.getElementById("c_image").style.display = "block";
          document.getElementById("r_image").style.display = "block";
          document.getElementById('procName').innerHTML = "Traning Success";
          $('#overlay').modal('hide');
          $('#captured_images').modal({
              backdrop: 'static',
              keyboard: false 
           });
          showImages(responseData.r_student.face_id)
        }
      }

     }});
  }

  function showImages(student_id){
    
     var image_string = "<div class=\"m-row\">";
      var count = 1;
      image_string += "<div class=\"m-column\">";
	  for(count = 1; count <= 2; count++){
        image_string += "<img src=\"../img/dataset/User."+student_id+"."+count+".jpg?"+new Date().getTime()+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
	  
	  image_string += "<div class=\"m-column\">";
      for(count = 3; count <= 5; count++){
        image_string += "<img src=\"../img/dataset/User."+student_id+"."+count+".jpg?"+new Date().getTime()+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
	  
	  image_string += "<div class=\"m-column\">";
      for(count = 6; count <= 8; count++){
        image_string += "<img src=\"../img/dataset/User."+student_id+"."+count+".jpg?"+new Date().getTime()+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
	  
	  image_string += "<div class=\"m-column\">";
      for(count = 9; count <= 10; count++){
        image_string += "<img src=\"../img/dataset/User."+student_id+"."+count+".jpg?"+new Date().getTime()+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
      // for(count = 1; count <= 7; count++){
        // image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      // }
      // image_string += "</div>"

      
      // image_string += "<div class=\"m-column\">";
      // for(count = 8; count <= 15; count++){
        // image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      // }
      // image_string += "</div>"

      
      // image_string += "<div class=\"m-column\">";
      // for(count = 16; count <= 23; count++){
        // image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      // }
      // image_string += "</div>"


      
      // image_string += "<div class=\"m-column\">";
      // for(count = 24; count <= 30; count++){
        // image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      // }
      // image_string += "</div>"

      
      image_string += "</div>";

    document.getElementById('card_body').innerHTML = image_string;
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

  function reRegister(){
    var main_url = '/updatecamera/';
    $.ajax({url: main_url, success: function(responseData){
       console.log(responseData);
     }});
  }

  function cancelRegistration(){
    var main_url = '/cancelregistration/';
    $.ajax({url: main_url, success: function(responseData){
       console.log(responseData);
     }});
  }

  function confirmImage(){
    var main_url = '/deletecamera/';
    $.ajax({url: main_url, success: function(responseData){
       console.log(responseData);
       $('#captured_images').modal('hide');
     }});
  }

  function deleteProfile(context,sub_id){
    $.ajax({
        url: "/profiledelete/"+sub_id,
        success: function(responseData) {
            $(context).closest('tr').remove();
            showModal();
        }
    });
  }


  function sortData(sortcolum,sort,isSearch){
    var rows ="";
    var main_url = ''
    var search = document.getElementById("search").value.trim();
    if(isSearch){
      main_url = '/searchstudents/'+search
    }else{
      main_url = '/sortstudents/'+sortcolum+'/'+sort
    }

    console.log(main_url);
  
      $.ajax({url: main_url, success: function(responseData){
          $.each(responseData.studentlist, function(i, item) {
            rows += "<tr >"
            rows +=  "<td style='cursor:pointer; vertical-align: middle;' class='clickable-row' data-href='/profile/" + item.id + "'>"+item.name+"</td>";
            rows +=  "<td style='cursor:pointer; vertical-align: middle;' class='clickable-row' data-href='/profile/" + item.id + "'>"+item.grade_level+"</td>";
            rows +=  "<td style='cursor:pointer; vertical-align: middle;' class='clickable-row' data-href='/profile/" + item.id + "'>"+item.section+"</td>";
            rows +=  "<td style='cursor:pointer; vertical-align: middle;' class='clickable-row' data-href='/profile/" + item.id + "'>"+item.dob+"</td>";
            rows +=  "<td style='cursor:pointer; vertical-align: middle;' class='clickable-row' data-href='/profile/" + item.id + "'>"+item.mobile_number+"</td>";
            rows +=  "<td style='cursor:pointer; vertical-align: middle;' class='clickable-row' data-href='/profile/" + item.id + "'>"+item.address+"</td>";
            rows +=  "<td style='cursor:pointer; vertical-align: middle;' class='clickable-row' data-href='/profile/" + item.id + "'>"+item.created_at+"</td>";
            rows += "<td>\
                      <div class=\"text-center\" style=\"background-color: white\">\
                        <a class=\"btn btn-primary btn-sm\" href=\"/edit/"+item.id+"\"> Edit</a>"
            if (item.registered == 0){
              rows += " <button class=\"btn btn-success btn-sm\"  onclick=\"faceRegister(this, "+item.id+")\" > Register</button>"
            }else{
              rows += " <button class=\"btn btn-warning btn-sm\"  onclick=\"faceRegister(this, "+item.id+")\" > Reregister</button>"
            }
            rows += " <button class=\"btn btn-danger btn-sm\"  style=\"margin-top: 5px;\" onclick=\"deleteProfile(this, "+item.id+")\" > Delete</button>"
           
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
