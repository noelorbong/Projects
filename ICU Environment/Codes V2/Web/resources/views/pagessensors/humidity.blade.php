@extends('layouts.coreuiadmin')

@section('title')
Humidity ICu Environment
@endsection

@section('bodyTitle')
Humidity
@endsection

@section('customCSS')
@endsection
<style type="text/css">
</style>
@section('content')
<div class="card">
  <div class="card-header">
  <i class="nav-icon fa fa-tint"></i> Real Time Humidity Graph 
  <span class="pull-right">
    Graph Type: <select id="humiGraphType" onChange="humirequestData()">
            <option value="line" >Line</option>
            <option value="bar" >Bar</option>
        </select>
  </span>
  </div>
  <div id="cardBody"class="card-body" style="padding:10px; margin:0;">
    <div id="humichartContent" >
        <canvas id="humiChart"  width="100%" height="40vh"></canvas>
    </div>
  </div>
  <div class="card-footer text-muted">
    <span  id="humiCurrentDate" class="text-muted pull-left" ></span>
  </div>
  
</div>
@endsection

@section('customScript')
<script src="../js/sensorschart/humidity.js"></script>
@endSection
