@extends('layouts.coreuiadmin')

@section('title')
List RFID
@endsection

@section('bodyTitle')
Users|List
@endsection

@section('customCSS')
<style>
    .pagination{
        justify-content:center;
    }
    .pagination > li > a {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #20a8d8;
        background-color: #fff;
        border: 1px solid #c8ced3;
    }
    .pagination >li >span {
        color: #73818f;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #c8ced3;
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        border: 1px solid #c8ced3;
    }
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
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-list-alt"></i> User List 
    <span class="pull-right">
    <div class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" id="search" name="search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" id="searchbtn" onlclick="searchLog()">Search</button>
    </div>
    </span>
  </div>
  <div class="card-body" style="padding:0px; margin:0;">
    <div class="table-responsive">
      <table class="table text-center">
          <thead class="thead-dark">
              <tr>
              <th scope="col">User Type.
                <span class="rfidUserType fa fa-caret-down" ></span>
              </th>
              <th scope="col">RFID No.
                <span class="rfidCaret fa fa-caret-down" ></span>
              </th>
              <th scope="col">Plate No.
                <span  class="rfidPlate fa fa-caret-down" ></span>
              </th>
              <th scope="col">Name
              <span class="rfidAccount fa fa-caret-down" ></span>
              </th>
              <th scope="col">Address
              <span  class="rfidHouse fa fa-caret-down" ></span>
              </th>
              <th scope="col">State
              <span  class="rfidState fa fa-caret-down" ></span>
              </th>
              <th scope="col">Date Created
              <span class="rfidDate fa fa-caret-down" ></span>
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
@endsection

@section('customScript')
<script>
    $(function() { 
        sortData("account_name","ASC")
    });
    document.getElementById("searchbtn").addEventListener("click", searchLog);
    function searchLog(){
        var search = document.getElementById("search").value.trim();
        if(search != ""){
            console.log(search);
            var url = "/searchrfid/"+ search;
            window.location.href = url;
        }
        
    }
    $(document).ready(function () {
        $('.rfidUserType').on('click', function () {
            if ($(this).hasClass('fa-caret-down')) {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
                    sortData("user_type","ASC");
            }else{
                $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
                sortData("user_type","DESC");
            }
        });
    });

    $(document).ready(function () {
        $('.rfidCaret').on('click', function () {
            if ($(this).hasClass('fa-caret-down')) {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
                    sortData("rfid_no","ASC");
            }else{
                $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
                sortData("rfid_no","DESC");
            }
        });
    });

    $(document).ready(function () {
        $('.rfidPlate').on('click', function () {
            if ($(this).hasClass('fa-caret-down')) {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
                    sortData("plate_no","ASC");
            }else{
                $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
                sortData("plate_no","DESC");
            }
        });
    });

    $(document).ready(function () {
        $('.rfidAccount').on('click', function () {
            if ($(this).hasClass('fa-caret-down')) {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
                    sortData("account_name","ASC");
            }else{
                $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
                sortData("account_name","DESC");
            }
        });
    });

    $(document).ready(function () {
        $('.rfidHouse').on('click', function () {
            if ($(this).hasClass('fa-caret-down')) {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
                    sortData("house_address","ASC");
            }else{
                $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
                sortData("house_address","DESC");
            }
        });
    });

     $(document).ready(function () {
        $('.rfidState').on('click', function () {
            if ($(this).hasClass('fa-caret-down')) {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
                    sortData("state","ASC");
            }else{
                $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
                sortData("state","DESC");
            }
        });
    });

    $(document).ready(function () {
        $('.rfidDate').on('click', function () {
            if ($(this).hasClass('fa-caret-down')) {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
                    sortData("created_at","ASC");
            }else{
                $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
                sortData("created_at","DESC");
            }
        });
    });

    function sortData(sortcolum,sort){
    var path = window.location.pathname;
    var res = path.split("/");
    var Mainurl ="";
    
    var rows ="";
    if (res[1] == "searchrfid"){
        Mainurl = "/sortrfidli/"+res[2]+"/"+sortcolum+"/"+sort;
    }else{
        Mainurl = "/sortrfidli/"+sortcolum+"/"+sort;
    }

    console.log(Mainurl);
 
  $.ajax({url: Mainurl, success: function(responseData){
      $.each(responseData.rfidusers, function(i, item) {
        rows += "<tr>"
        
        rows +=  "<td>"+item.user_type+"</td>";
        rows +=  "<td>"+item.rfid_no+"</td>";
        rows +=  "<td>"+item.plate_no+"</td>";
        rows +=  "<td>"+item.account_name+"</td>";
        rows +=  "<td>"+item.house_address+"</td>";
        var state = "Unused";
        if(item.state != null){
          state = (item.state == 1) ? 'In':'Out';
        }
        rows +=  "<td>"+state+"</td>";
        rows +=  "<td>"+item.created_at+"</td>";
        rows += "<td>\
                  <div class=\"text-center\" style=\"background-color: white\">\
                    <a class=\"btn btn-primary btn-sm\" href=\"/useredit/"+item.id+"\"> Edit</a>\
                        <button onclick=\"deleteLog(this,"+item.id+")\" class=\"btn btn-danger btn-sm\">\
                        Delete\
                      </button>\
                  </div>\
              </td>"
        rows += "</tr>"
      });  

       document.getElementById('tbody').innerHTML = '';
       $('#tbody').append(rows);          
  }});

}

function deleteLog(context, id_no){
    var Mainurl = "/userdelete/"+id_no;
    $.ajax({url: Mainurl, success: function(responseData){
        if (responseData == "success"){
            $(context).closest('tr').remove();
            console.log(id_no);  
        }
        console.log(responseData);
    }});
}
</script>
@endSection
