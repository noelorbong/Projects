@extends('layouts.coreuiadmin')

@section('title')
Edit SMS Subscriber
@endsection

@section('bodyTitle')
Edit Subscriber|Add
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-pencil"></i>Edit SMS Subscriber
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <form action="/smsupdate" method="POST">
        {{ csrf_field() }}
        <input type="hidden" value="{{ $subscriber->id }}"  class="form-control" name="id" id="id" required>
        <div class="form-group">
            <input type="checkbox"  onclick="checkActive()" name="active" id="active" value="{{ $subscriber->active }}" {{ $subscriber->active == 1 ? 'checked':'' }}>
            <label for="name">Active</label>
            
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Subscriber Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $subscriber->name }}" placeholder="e.g Pepito Manoloto" required>
            </div>
            <div class="form-group col-md-6">
            <label for="number">Mobile No.</label>
            <input type="number" class="form-control" name="number" id="number"  value="{{ $subscriber->number }}"  placeholder="e.g 09272327745" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
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
