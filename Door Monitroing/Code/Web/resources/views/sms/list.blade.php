@extends('layouts.coreuiadmin')

@section('title')
List SMS Subcriber
@endsection

@section('bodyTitle')
SMS Subcriber |List
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
    <i class="nav-icon fa fa-list-alt"></i> SMS Subcribers List 
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
                <th scope="col">Mobile Number
                </th>
                <th scope="col">Active
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
        <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
            <p class="btn btn-success">Success</p>
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script>
  $(function() {
      sortData("name","ASC", false)
  });

    function showModal() {
        $('#overlay').modal('show');

        setTimeout(function() {
                    $('#overlay').modal('hide');
        }, 500);
    }

  function sortData(sortcolum,sort, isSearch){
    var rows ="";
    var main_url = ''
    var subStatus = "";
    var search = document.getElementById("search").value.trim();
    if(isSearch){
      main_url = 'smssearch/'+search
    }else{
      main_url = 'smsget/'+sortcolum+'/'+sort
    }

    console.log(main_url);
  
      $.ajax({url: main_url, success: function(responseData){
          console.log(responseData);
          $.each(responseData.records, function(i, item) {
            rows += "<tr >"
            rows +=  "<td>"+item.name+"</td>";
            rows +=  "<td>"+item.number+"</td>";
            if(item.active==1){
                subStatus = "checked"
            }else{
                subStatus = "";
            }
            rows +=  "<td><input type=\"checkbox\"  onclick=\"changeStatus(this,"+item.id+")\" "+subStatus+"></td>";
            rows +=  "<td>"+item.created_at+"</td>";

            rows += "<td>\
                      <div class=\"text-center\" style=\"background-color: white\">\
                        <a class=\"btn btn-primary btn-sm\" href=\"/smsedit/"+item.id+"\"> Edit</a>"
                        rows += " <button class=\"btn btn-danger btn-sm\"  onclick=\"deleteSMSSub(this, "+item.id+")\" > Delete</button>"
           
            rows += "</div> </td>"

            rows += "</tr>"
          });  

          document.getElementById('tbody').innerHTML = '';
          $('#tbody').append(rows);         
      }});

  }

  function changeStatus(context, sub_id){
    var checkStatus = "1";
    if (context.checked)
    {
        checkStatus = "1"
    }else{
        checkStatus = "0"
    }
    console.log(checkStatus)
    console.log(sub_id);
    $.ajax({
        url: "/updatesmsstatus/"+sub_id+"/"+checkStatus,
        success: function(responseData) {
            showModal();
        }
    });
  }

function deleteSMSSub(context,sub_id){
    $.ajax({
        url: "/smsdelete/"+sub_id,
        success: function(responseData) {
            $(context).closest('tr').remove();
            showModal();
        }
    });
  }
</script>
@endSection
