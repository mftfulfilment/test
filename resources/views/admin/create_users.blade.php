@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create new user</div>

                    <div class="panel-body">
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('sainik_no') ? ' has-error' : '' }}">
                                    <label for="sainik_no" class="col-md-4 control-label">Sainik No</label>

                                    <div class="col-md-6">
                                        <input id="sainik_no" type="text" class="form-control" name="sainik_no" value="{{ old('sainik_no') }}" required autofocus>

                                        @if ($errors->has('sainik_no'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('sainik_no') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('rank') ? ' has-error' : '' }}">
                                    <label for="rank" class="col-md-4 control-label">Rank</label>

                                    <div class="col-md-6">
                                        <input id="rank" type="text" class="form-control" name="rank" value="{{ old('rank') }}" required autofocus>

                                        @if ($errors->has('rank'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('rank') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}">
                                    <label for="unit" class="col-md-4 control-label">Unit</label>

                                    <div class="col-md-6">
                                        <input id="unit" type="text" class="form-control" name="unit" value="{{ old('unit') }}" required autofocus>

                                        @if ($errors->has('unit'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('unit') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('profile_img') ? ' has-error' : '' }}">
                                    <label for="profile_img" class="col-md-4 control-label">Profile Image</label>

                                    <div class="col-md-6">
                                        <input type="file" name="profile_img" value="{{ old('profile_img') }}" id="profile_img" class="">
                                        @if ($errors->has('profile_img'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('profile_img') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address" class="col-md-4 control-label">Address</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
