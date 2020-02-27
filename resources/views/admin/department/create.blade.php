@extends('layouts.master')
@section('content-header')
<div class="container-fluid admin-role-create">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Create Department</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/department')}}">admin</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/department/')}}">department</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/department/create')}}">create</a></li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@endsection
@section('content')
@if(Session::has('created_department'))
<p class="bg-success" style="font-weight: bold;font-size: 16px;padding: 10px 10px;text-align:center;">{{session('created_department')}}</p>
@endif
@if(Session::has('created_department_fail'))
<p class="bg-danger" style="font-weight: bold;font-size: 16px;padding: 10px 10px;text-align:center;">{{session('created_department_fail')}}</p>
@endif
    {!! Form::open(['method'=>'POST','action'=>'DepartmentController@store','files'=>true]) !!}
        <div class="form-group">
            {!! Form::label('name','Name:') !!}
            {!! Form::text('name',null,['class'=>'form-control','required']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Create Department',['class'=>'form-control btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    {{-- @include('includes.errors') --}}
@endsection