@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Leave List</div>

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

                        <hr>
                        <div class="col-md-12">
                            <table id="example" class="table table-hover table-responsive" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Applicant Name</th>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>Till</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leave_list as $leave)

                                    <tr>
                                        <th>{{ $leave->username }}</th>
                                        <th>{{ $leave->name }}</th>
                                        <th>{{ $leave->leave_from }}</th>
                                        <th>{{ $leave->leave_till }}</th>
                                        <th>
                                            <a href="{{route('leave_approve',['leave_id'=>$leave->leave_id])}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></a>
                                            <a href="{{route('leave_cancel',['leave_id'=>$leave->leave_id])}}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                        </th>
                                    </tr>
                                @endforeach;
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_link')
    {{--    <script src="{{ asset('public/js/jquery-1.12.4.js') }}"></script>
        <script src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/js/dataTables.bootstrap.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>--}}
@endsection