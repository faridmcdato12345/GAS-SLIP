@extends('layouts.userprofile')
@section('content-header')
<div class="container-fluid admin-user-index">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark"></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/users')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/userprofile')}}">user profile</a></li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
    @if($users)
    <table class="table">
        <tbody>
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{$users->name}}</td>
            </tr>
            <tr>
                <td><strong>Email Address:</strong></td>
                <td>{{$users->email}}</td>
            </tr>
            <tr>
                <td><strong>Role:</strong></td>
                <td>{{$role}}</td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>{{$users->is_active==1?'Active':'In Active'}}</td>
            </tr>
        </tbody>
    </table>
    @endif
@endsection