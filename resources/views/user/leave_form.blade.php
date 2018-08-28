@extends('layouts.auth')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Leave Apply</div>

        <div class="panel-body">
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    @if (session('mess'))
                        <div class="alert alert-danger">
                            {{ session('mess') }}
                        </div>
                    @endif

                        <div class="">
                            <h4 class="text-center text-info">Leave Status</h4>
                            <table class="table table-responsive table-bordered table-hover">
                                <thead>
                                    <td>Leave Type</td>
                                    <td>Leave Limit</td>
                                    <td>Leave Taken</td>
                                    <td>Leave Available</td>
                                </thead>
                                @if ($leave_not_taken)
                                    @foreach($leave_not_taken as $not_taken)
                                        <tr>
                                            <td>{{$not_taken->name}}</td>
                                            <td>{{$not_taken->limit}}</td>
                                            <td>0</td>
                                            <td>{{$not_taken->limit}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if ($leave_taken)
                                    @foreach($leave_taken as $taken)
                                        <tr>
                                            <td>{{$taken->name}}</td>
                                            <td>{{$taken->limit}}</td>
                                            <td>{{$taken->take}}</td>
                                            <td>{{$taken->limit-$taken->take}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>

                <form class="form-horizontal" method="POST" action="{{ route('apply_to_leave') }}">
                    {{ csrf_field() }}


                    <div class="form-group{{ $errors->has('leave_no') ? ' has-error' : '' }}">
                        <label for="leave_no" class="col-md-4 control-label">Leave Type</label>

                        <div class="col-md-6">
                            <select name="leave_no" class="form-control">
                                <option value="">Select One</option>
                                @foreach($leave_list as $leave)
                                    <option value="{{$leave->id}}">{{$leave->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('leave_no'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('leave_no') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('leave_from') ? ' has-error' : '' }}">
                        <label for="leave_from" class="col-md-4 control-label">Leave From</label>

                        <div class="col-md-6">
                            <input autocomplete="off" type="text" class="form-control datepicker" name="leave_from" value="{{ old('leave_from') }}" autofocus>

                            @if ($errors->has('leave_from'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('leave_from') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    {{--////--}}


                    {{--///sdf--}}

                    <div class="form-group{{ $errors->has('leave_till') ? ' has-error' : '' }}">
                        <label for="leave_till" class="col-md-4 control-label">Leave Till</label>

                        <div class="col-md-6">
                            <input id="datepicker1" autocomplete="off" type="text" class="form-control datepicker" name="leave_till" value="{{ old('leave_till') }}" autofocus>

                            @if ($errors->has('leave_till'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('leave_till') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                        <label for="reason" class="col-md-4 control-label">Leave Reason</label>

                        <div class="col-md-6">
                            <input id="reason" type="text" class="form-control" name="reason" value="{{ old('reason') }}" autofocus>

                            @if ($errors->has('reason'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('reason') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Apply
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection