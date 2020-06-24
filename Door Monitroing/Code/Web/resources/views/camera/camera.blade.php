@extends('layouts.coreuiadmin')

@section('title')
Camera
@endsection

@section('bodyTitle')
Camera
@endsection

@section('customCSS')
<style type="text/css">
	.camera{
		height:65vh; 
		width:100%;
	}

</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-camera"></i>Camera
  </div>
  <div class="card-body" style="padding:0px; margin:0;">
    <iframe  id="modify-me" src=""  class="camera" ></iframe>
  </div>
  <div class="card-footer text-muted">
    <a class="pull-right"  href="/" onclick="javascript:event.target.port=8765" target="_blank">More</a>
  </div>
</div>
@endsection

@section('customScript')
<script>
 $(function() {
    document.getElementById('modify-me').src = window.location.protocol + "//" + window.location.hostname + ":8765/";
  });
</script>
@endSection
