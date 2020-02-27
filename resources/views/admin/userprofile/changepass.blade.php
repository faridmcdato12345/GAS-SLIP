@extends('layouts.userprofile')
@section('content-header')
<div class="container-fluid admin-user-index">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Change Password</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin/users')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/userprofile')}}">user profile</a></li>
            <li class="breadcrumb-item active"><a href="{{url('admin/changepass')}}">change password</a></li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('content')
    <div class="col-sm-12">
        @if (Session::has('success'))
            <div class="alert alert-success">{!! Session::get('success') !!}</div>
        @endif
        @if (Session::has('failure'))
            <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
        @endif
        <form action="{{ route('password.update') }}" method="post" role="form" class="form-horizontal">
            {{csrf_field()}}
                <div class="form-group{{ $errors->has('old') ? ' has-error' : '' }}">
                    <label for="password">Current Password</label>

                    <div>
                        <input id="password" type="password" class="form-control" name="old">

                        @if ($errors->has('old'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">New Password</label>

                    <div>
                        <input id="password" type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm">Confirm New Password</label>

                    <div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div>
                    <button type="submit" class="btn btn-primary form-control">Save</button>
                        </div>
                </div>
        </form>
    </div>
@endsection

