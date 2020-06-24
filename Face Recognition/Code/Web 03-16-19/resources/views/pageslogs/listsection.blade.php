@extends('layouts.coreuiadmin')

@section('title')
{{ $grade_level }} Log
@endsection

@section('bodyTitle')
{{ $grade_level }} Log
@endsection

@section('customCSS')
<style>
    .brand-card-header{
        background-color:#20821f;
    }
 
</style>
@endsection

@section('content')

<div class="row">
    @forelse($sections as $section)
    <div onclick="location.href='/sectionlistlog/{{$grade_level}}/{{$section->section}}';" style="cursor: pointer;" class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="brand-card-header">
                <i class="fa fa-file-text"></i>
            </div>
            <div class="brand-card-body">
                <div>
                    <div id="totalIn" class="text-value">{{$section->section}}</div>
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
