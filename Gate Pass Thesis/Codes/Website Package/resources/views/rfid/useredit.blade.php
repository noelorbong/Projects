@extends('layouts.coreuiadmin')

@section('title')
Edit RFID
@endsection

@section('bodyTitle')
Users|Edit
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-pencil-square-o "></i> User Edit 
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <form action="/userupdate/{{ $rfiduser->id }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="account_name" >User Type</label>
            <select name="user_type" class="form-control">
                <option value="Owner" {{ $rfiduser->user_type == 'Owner' ? 'selected': ''}}>Owner</option>
                <option value="Guest" {{ $rfiduser->user_type == 'Guest' ? 'selected': ''}}>Guest</option>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="rfid_no">RFID No.</label>
            <input value="{{ $rfiduser->rfid_no}}" type="number" class="form-control" name="rfid_no" id="rfid_no" placeholder="RFID No." required>
            </div>
            <div class="form-group col-md-6">
            <label for="plate_no">Plate No.</label>
            <input value="{{ $rfiduser->plate_no}}" type="text" class="form-control" name="plate_no" id="plate_no" placeholder="Plate No." required>
            </div>
        </div>
        <div class="form-group">
            <label for="account_name">Account Name</label>
            <input value="{{ $rfiduser->account_name}}" type="text" class="form-control" name="account_name" id="account_name" placeholder="Account Name" required>
        </div>
        <div class="form-group">
            <label for="house_address">House Address</label>
            <input value="{{ $rfiduser->house_address}}" type="text" class="form-control" name="house_address" id="house_address" placeholder="1234 Main St, Apartment, studio, or floor" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
  
</div>
@endsection

@section('customScript')

@endSection
