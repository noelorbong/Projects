@extends('layouts.coreuiadmin')

@section('title')
Register Face Students
@endsection

@section('bodyTitle')
Students|Register Face
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-plus"></i> Face Recognition Dataset
    <span class="pull-right">
    <div class="form-inline my-2 my-lg-0">
      <button class="btn btn-success btn-sm" id="searchbtn">Capture Images</button>
    </div>
    </span>
  </div>
  <div class="card-body" style="padding:5px; margin:0;">  
    <iframe style="width: 100%; height:65vh;"  id="camera"></iframe>
  </div>
</div>
@endsection

@section('customScript')
<script>
 var windowLocation = "";

$(function() { 
        windowLocation = "/camera"//window.location.protocol + "//" + window.location.hostname + ":8081/";
        document.getElementById('camera').src = windowLocation; 
});
</script>
@endSection
