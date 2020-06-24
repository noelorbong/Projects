@extends('layouts.coreuiadmin')

@section('title')
Add Email Subscriber
@endsection

@section('bodyTitle')
Email Subscriber|Add
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-plus"></i>Add Email Subscriber
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <form action="/emailstore" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="checkbox"  onclick="checkActive()" name="active" id="active" value=1>
            <label for="name">Active</label>
            
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Subscriber Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="e.g Pepito Manoloto" required>
            </div>
            <div class="form-group col-md-6">
            <label for="number">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="e.g example@gmail.com" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
  
</div>
@endsection

@section('customScript')
<script>

    function checkActive()
    {
        var checkbox = document.getElementById('active');
        if (checkbox.checked != true)
        {
            checkbox.value = 0
        }else{
            checkbox.value = 1
        }
    }
</script>
@endSection
