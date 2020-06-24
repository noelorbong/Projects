@extends('layouts.coreuiadmin')

@section('title')
Camera ICu Environment
@endsection

@section('bodyTitle')
Camera
@endsection

@section('customCSS')
<style type="text/css">
	.camera{
		height:70vh; 
		width:100%;
	}
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
  <i class="nav-icon fa fa-camera"></i> Camera Admin
  </div>
  <div class="card-body" style="padding:0; margin:0;">
    <iframe  id="camera" src=""  class="camera" ></iframe>
  </div>
  <div class="card-footer text-muted">
    <a class="pull-right"  href="/" onclick="javascript:event.target.port=8765" target="_blank">More</a>
  </div>
</div>
@endsection

@section('customScript')
<script type="text/javascript">
    $(function() {
        document.getElementById('camera').src = window.location.protocol + "//" + window.location.hostname + ":8081/";
    });
</script>
@endSection
