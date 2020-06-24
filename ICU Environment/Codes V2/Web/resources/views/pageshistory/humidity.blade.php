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
  <i class="nav-icon fa fa-tint"></i>Humidity Graph History
  <span class="pull-right">
       Graph Type: <select id="graphType" onChange="handler();">
            <option value="line" >Line</option>
            <option value="bar" >Bar</option>
        </select>
  </span>
  </div>
  <div id="cardBody"class="card-body" style="padding:10px; margin:0;">
    <div id="chartContent" >
        <canvas id="humiChart"  width="100%" height="40vh"></canvas>
    </div>
  </div>
  <div class="card-footer text-muted">
         Start Date: <input id="startTime" type="datetime-local"   required>
         End Date: <input id="endTime" type="datetime-local"   required>
         <button onclick="handler()" >Select</button>
  </div>
</div>
@endsection

@section('customScript')
<script src="../js/sensorschart/humihistory.js"></script>
@endSection