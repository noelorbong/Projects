@extends('layouts.coreuiadmin')

@section('title')
CO2 ICu Environment
@endsection

@section('bodyTitle')
CO2
@endsection

@section('customCSS')
@endsection
<style type="text/css">
</style>
@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-flask"></i> 
    Real Time CO2 Graph 
    <span class="pull-right">
    Graph Type: <select id="co2GraphType" onChange="co2requestData()">
            <option value="line" >Line</option>
            <option value="bar" >Bar</option>
        </select>
  </span>
  </div>
  <div class="card-body" style="padding:10px; margin:0;">
    <div id="co2chartContent" >
        <canvas id="co2Chart"  width="100%" height="40vh"></canvas>
    </div>
  </div>
  <div class="card-footer text-muted">
    <span  id="co2CurrentDate" class="text-muted pull-left" ></span>
  </div>
  
</div>
@endsection

@section('customScript')
<script src="../js/sensorschart/co2.js"></script>
@endSection
