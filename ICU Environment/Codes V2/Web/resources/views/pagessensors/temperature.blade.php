@extends('layouts.coreuiadmin')

@section('title')
Temperature ICu Environment
@endsection

@section('bodyTitle')
Temperature
@endsection

@section('customCSS')
@endsection
<style type="text/css">
</style>
@section('content')
<div class="card">
  <div class="card-header">
  <i class="nav-icon fa fa-thermometer-half"></i> Real Time Temperature Graph 
  <span class="pull-right">
    Graph Type: <select id="tempGraphType" onChange="requestData()">
            <option value="line" >Line</option>
            <option value="bar" >Bar</option>
        </select>
  </span>
  </div>
  <div id="cardBody"class="card-body" style="padding:10px; margin:0;">
    <div id="chartContent" >
        <canvas id="tempChart"  width="100%" height="40vh"></canvas>
    </div>
  </div>
  <div class="card-footer text-muted">
    <span  id="tempCurrentDate" class="text-muted pull-left" ></span>
  </div>
</div>
@endsection

@section('customScript')
<script src="../js/sensorschart/temperature.js"></script>
@endSection
