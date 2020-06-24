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
@endsection

@section('customScript')
<script>
     function editAccount(id) {
        window.location.href = "/edit/" + id;
    }

    function checkLogs(){
        $('#overlay').modal('show');
    }
</script>
@endSection
