@extends('layouts.master')
@section('content-header')
<div class="container-fluid admin-user-create">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Create user</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/users')}}">Admin</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/users/create')}}">Create user</a></li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@endsection
@section('content')
@if(Session::has('created_user'))
<p class="bg-success" style="font-weight: bold;font-size: 16px;padding: 10px 10px;">{{session('created_user')}}</p>
@endif
    {!! Form::open(['method'=>'POST','action'=>'AdminUserController@store','files'=>true]) !!}
        <div class="form-group">
            {!! Form::label('name','Name:') !!}
            {!! Form::text('name',null,['class'=>'form-control','required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('username','Username:') !!}
            {!! Form::text('username',null,['class'=>'form-control','required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email','Email:') !!}
            {!! Form::email('email',null,['class'=>'form-control','required']) !!}
            {{--{{ Form::hidden('type_id', '2') }}--}}
        </div>
        <div class="form-group">
            {!! Form::label('role_id','Role:') !!}
            {!! Form::select('role_id',[''=>'Choose option'] + $roles ,null,['class'=>'form-control','required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('department_id','Department:') !!}
            {!! Form::select('department_id',[''=>'Choose option'] + $departments ,null,['class'=>'form-control','required']) !!}
        </div>
        <div class="form-group">
             {!! Form::label('file','Upload signature image:') !!}
             {!! Form::file('signature_id',['class'=>'']) !!}
         </div>
        <div class="form-group">
            {!! Form::label('Password','Password:') !!}
            {!!  Form::text('password',$randompassword,['class' => 'form-control','required']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Create User',['class'=>'form-control btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    {{-- @include('includes.errors') --}}
@endsection
@section('datatable-script')
@endsection