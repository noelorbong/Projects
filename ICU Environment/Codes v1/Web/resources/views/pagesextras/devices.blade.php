@extends('layouts.coreuiadmin')

@section('title')
Devices ICu Environment
@endsection

@section('bodyTitle')
Devices
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
  <i class="nav-icon fa fa-plug"></i> Devices
  </div>
  <div class="card-body" style="padding:0; margin:0;">
    <div class="row">
        <div class="col-sm-12 col-xl-6 text-center">
            <h5 class="card-title" style="margin-top:10px">Fan</h5>
            
            <img  style="height:auto; width: 80%; object-fit: contain;" id="electricFan" src="/img/icons/icon_fan_on.png">
            
        </div>
        <div class="col-sm-12 col-xl-6">
            <h5 class="card-title text-center" style="margin-top:10px">Buzzer</h5>
            <img   style="height:auto; width: 80%; object-fit: contain;display: block;margin-left: auto; margin-right: auto;" id="alarmBuzzer" src="/img/icons/icon_alarm_on.png">
        </div>
    </div>
  </div>
</div>
@endsection

@section('customScript')
<script src="../js/sensorschart/device.js"></script>
@endSection
