@extends('layouts.coreuiadmin')

@section('title')
Dashboard Face Recognition
@endsection

@section('bodyTitle')
Dashboard
@endsection

@section('customCSS')
<style type="text/css">
object  {
    width: 100%;
    height: 80vh;
    border: 0
}
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa  fa-file-pdf-o"></i> User Manual
  </div>
  <div class="card-body" style="padding:0; margin:0;">
    <!-- <embed   src="/documents/User_Manual.pdf" /> -->
    <!-- <iframe src="../documents/User_Manual.pdf" style="width: 100%;height: 100%;border: none;"></iframe> -->
  
    <object data="/documents/User_Manual.pdf" type="application/pdf" ></object>
  </div>
</div>
@endsection

@section('customScript')

@endSection
