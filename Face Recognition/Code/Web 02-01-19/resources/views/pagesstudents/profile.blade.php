@extends('layouts.coreuiadmin')

@section('title')
Profile Student
@endsection

@section('bodyTitle')
Profile
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
    min-width:200px;
  }
.carousel-item{
margin:auto;
height: 400px;
}
.carousel-inner .carousel-item img{
margin:auto;
width: 400px !important;
height: 400px;
}

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
    <i class="nav-icon fa fa-pencil"></i> Students Profile 
    <span style="float:right">
        <button onclick="editAccount('{{ $student->id }}')" class="btn btn-primary btn-sm"><i class="nav-icon fa fa-pencil"> </i> Edit</button>
    </span>
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <form action="/studentupdate" method="POST">
        {{ csrf_field() }}
        <input type="hidden" value="{{ $student->id }}"  class="form-control" name="id" id="id" readonly>
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" value="{{ $student->name }}"  class="form-control" name="name" id="name" placeholder="Student Name" readonly>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="dob">Date of Birth</label>
            <input type="date" value="{{ $student->dob }}"  class="form-control" name="dob" id="dob" placeholder="Date of Birth" readonly>
            </div>
            <div class="form-group col-md-6">
            <label for="mobile_number">Guardian No.</label>
            <input type="text" class="form-control" value="{{ $student->mobile_number }}" name="mobile_number" id="mobile_number" placeholder="Mobile No." readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" value="{{ $student->address }}"  id="address" placeholder="1234 Main St, Apartment, studio, or floor" readonly>
        </div>
        
    </form>
  </div>
  <div class="card-footer text-muted">
  <button onclick="checkLogs()" class="btn btn-primary"><i class="nav-icon fa fa-clipboard"> </i> Log History</button>
  </div>
</div>
@if ($student->registered == 1)
<div class="card">
    <div class="card-header">
    <i class="nav-icon fa fa-picture-o"></i> {{ $student->name }} Registered Images
    
        <button style="float:right; position:relative; z-index:10" onclick="showAll('{{ $student->id }}')" class="btn btn-primary btn-sm"><i class="nav-icon fa fa-picture-o"> </i> Show All</button>
    
    </div>
    <div class="card-body" style="background-color:#777777">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				
                @for ($i = 0; $i < 9; $i++)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}"></li>
                @endfor
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="/img/dataset/User.{{$student->id}}.1.jpg?{{date('Y-m-d H:i:s')}}" alt="1 slide">
                    <div class="carousel-caption d-none d-md-block">
                        <p>1 out 10 images</p>
                    </div>
                </div>
                @for ($i = 2; $i < 11; $i++)
                <div class="carousel-item">
                    <img class="d-block w-100" src="/img/dataset/User.{{$student->id}}.{{$i}}.jpg?{{date('Y-m-d H:i:s')}}" alt="{{$i}} slide">
                    <div class="carousel-caption d-none d-md-block">
                        <p>{{$i}} out 10 images</p>
                    </div>
                </div>
                @endfor

                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>    
        </div>
    </div>
</div>
@endif
<div class="modal fade" id="overlay">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fff0;     border: 0px solid rgba(0, 0, 0, 0.2);">
            <div class="card">
                <div class="card-header">
                    Log History
                    <span type="button" class="close" data-dismiss="modal">&times;</span>
                </div>
                <div class="card-body" style="padding:0px;margin:0;">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody id="tbody" width="100%" height="40vh">
                            @forelse($records as $record)
                                <tr>
                                    <th scope="col">{{ $record->status == 1? 'In': 'Out' }}</th>
                                    <th scope="col">{{ $record->created_at }}</th>
                                </tr>
                            @empty
	                        @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="captured_images">
  <div class="modal-dialog">
    <div class="modal-content" >
        <div class="card">
          <div class="card-header">
          <i class="nav-icon fa fa-picture-o"></i>All Images
          </div>
          <div class="card-body" style="margin:0px; padding:0px; height:50vh">
            <div class="info-div" id="card_body">
            </div>
          </div>
        </div>
        </div>
  </div>
</div>
@endsection

@section('customScript')
<script>
    var d_time = new Date().toLocaleString();
     function editAccount(id) {
        window.location.href = "/edit/" + id;
    }

    function checkLogs(){
        $('#overlay').modal('show');
    }

    function showAll(student_id){
        console.log('test');
        showImages(student_id);
        $('#captured_images').modal('show');
    }

     function showImages(student_id){
    var image_string = "<div class=\"m-row\">";
      var count = 1;
      image_string += "<div class=\"m-column\">";
      for(count = 1; count <= 2; count++){
        image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
	  
	  image_string += "<div class=\"m-column\">";
      for(count = 3; count <= 5; count++){
        image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
	  
	  image_string += "<div class=\"m-column\">";
      for(count = 6; count <= 8; count++){
        image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
	  
	  image_string += "<div class=\"m-column\">";
      for(count = 9; count <= 10; count++){
        image_string += "<img src=\"/img/dataset/User."+student_id+"."+count+".jpg?"+d_time+"\" style=\"width:100%\">"
      }
      image_string += "</div>"
	
      
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
      image_string += "</div>"

      
      image_string += "</div>";

    document.getElementById('card_body').innerHTML = image_string;
  }
</script>
@endSection
