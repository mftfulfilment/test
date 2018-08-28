@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">User Profile</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="col-md-6">
                           <center> <h2 style="line-height: 4;margin-left: 195px;">Fact Sheet</h2></center>
                        </div>
                        <div class="col-md-3 col-md-offset-3">
                            <img style="max-height: 180px;margin-top: -10px;margin-bottom: 6px;" class="img-responsive img-thumbnail" src="{{asset('public/profile/1503911025_shimul.jpg')}}">
                        </div>
                        <table border="0" class="table table-responsive hover" style="font-size: 18px">


                            <tr>
                                <td>Sainik No:</td>
                                <td>{{$profile->sainik_no}}</td>
                            </tr>
                            <tr>
                                <td>Rank:</td>
                                <td>{{$profile->rank}}</td>
                            </tr>
                            <tr>
                                <td>Name:</td>
                                <td>{{$profile->name}}</td>
                            </tr>
                            <tr>
                                <td>Unit:</td>
                                <td>{{$profile->unit}}</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{{$profile->address}}</td>
                            </tr>

                        </table>
                            <br>
                        <center><h3>Leave History:</h3></center>
                        <table border="0" class="table table-responsive hover" style="font-size: 18px">
                            <tr>
                                <td>Leave Type</td>
                                <td>From</td>
                                <td>Till</td>
                                <td>Reason</td>
                                {{--<td>Reason</td>--}}
                            </tr>
                            @foreach ($leave_list as $leave)
                            <tr>
                                <td>
                                    {{$leave->name}}
                                </td>
                                <td>{{$leave->leave_from}}</td>
                                <td>{{$leave->leave_till}}</td>
                                <td>{{$leave->reason}}</td>
                                {{--<td>
                                    {{
                                        \App\Http\Controllers\AdminController::get_days_btw_date($leave->leave_from,$leave->leave_from)
                                    }}
                                </td>--}}
                            </tr>
                            @endforeach
                        </table>
                           {{-- <tr>
                                <td><a class="btn btn-success" href="{{route('update_password',['id'=>$leave->id])}}">Change Password</a> </td>
                                <td></td>
                            </tr>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
