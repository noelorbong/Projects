@extends('layouts.coreuiadmin')

@section('title')
Add Students
@endsection

@section('bodyTitle')
Students|Add
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-plus"></i> Students Add 
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <form action="/studentstore" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Student Name" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="dob">Date of Birth</label>
            <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" required>
            </div>
            <div class="form-group col-md-6">
            <label for="mobile_number">Guardian No.</label>
            <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Mobile No." required>
            </div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St, Apartment, studio, or floor" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
  
</div>
@endsection

@section('customScript')

@endSection
