@extends('layouts.coreuiadmin')

@section('title')
Edit Student
@endsection

@section('bodyTitle')
Students|Edit
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <i class="nav-icon fa fa-pencil"></i> Students Edit 
  </div>
  <div class="card-body" style="padding:30px; margin:0;">
    <form action="/studentupdate" method="POST">
        {{ csrf_field() }}
        <input type="hidden" value="{{ $student->id }}"  class="form-control" name="id" id="id" required>
 
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Student Name</label>
                <input type="text" value="{{ $student->name }}"  class="form-control" name="name" id="name" placeholder="Student Name" >
            </div>
            <div class="form-group col-md-6">
            <label for="gender">Gender</label>
                <select class="form-control" name="gender" id="gender"  >
                    <option value=1 {{ $student->gender === 1 ? 'Selected' :'' }}>Male</option>
                    <option value=0 {{ $student->gender === 0 ? 'Selected' :'' }}>Female</option>
                </select>
           </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="grade_level">Level</label>
            <input type="text" value="{{ $student->grade_level }}" class="form-control" name="grade_level" id="grade_level" placeholder="Eg. Grade 7" required>
            </div>
            <div class="form-group col-md-6">
            <label for="section">Section</label>
            <input type="text" value="{{ $student->section }}" class="form-control" name="section" id="section" placeholder="e.g. Section 1" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="dob">Date of Birth</label>
            <input type="date" value="{{ $student->dob }}"  class="form-control" name="dob" id="dob" placeholder="Date of Birth" required>
            </div>
            <div class="form-group col-md-6">
            <label for="mobile_number">Guardian No.</label>
            <input type="text" class="form-control" value="{{ $student->mobile_number }}" name="mobile_number" id="mobile_number" placeholder="Mobile No." required>
            </div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" value="{{ $student->address }}"  id="address" placeholder="1234 Main St, Apartment, studio, or floor" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
  
</div>
@endsection

@section('customScript')

@endSection
