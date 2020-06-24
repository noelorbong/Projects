@extends('layouts.coreuiadmin')

@section('title')
Add RFID
@endsection

@section('bodyTitle')
Users|Add
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-plus"></i> User Add 
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <form action="/userstore" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="account_name" >User Type</label>
            <select class="form-control" name="user_type">
                <option value="Owner">Owner</option>
                <option value="Guest">Guest</option>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="rfid_no">RFID No.</label>
            <input type="number" class="form-control" name="rfid_no" id="rfid_no" placeholder="RFID No." required>
            </div>
            <div class="form-group col-md-6">
            <label for="plate_no">Plate No.</label>
            <input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="Plate No." required>
            </div>
        </div>
        <div class="form-group">
            <label for="account_name">Account Name</label>
            <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Account Name" required>
        </div>
        <div class="form-group">
            <label for="house_address">House Address</label>
            <input type="text" class="form-control" name="house_address" id="house_address" placeholder="1234 Main St, Apartment, studio, or floor" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
  
</div>
@endsection

@section('customScript')

@endSection
