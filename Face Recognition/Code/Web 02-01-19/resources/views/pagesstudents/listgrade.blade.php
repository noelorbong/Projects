@extends('layouts.coreuiadmin')

@section('title')
Grade Level Students
@endsection

@section('bodyTitle')
Grade Level
@endsection

@section('customCSS')
<style>
    .brand-card-header{
        background-color:#5281fe;
    }
 
</style>
@endsection

@section('content')

<div class="row">
    @forelse($grade_levels as $grade_level)
    <div onclick="location.href='/sections/{{$grade_level->grade_level}}';" style="cursor: pointer;" class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="brand-card-header">
                <i class="fa fa-file-text"></i>
            </div>
            <div class="brand-card-body">
                <div>
                    <div id="totalIn" class="text-value">{{$grade_level->grade_level}}</div>
                </div>              
            </div>
        </div>
    </div><!--/.col-->
    @empty
    @endforelse
</div><!--/.row-->
@endsection

@section('customScript')
<script>
</script>
@endSection
