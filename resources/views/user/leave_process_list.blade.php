@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Leave Pending List</div>

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
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>Till</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leave_list as $leave)

                                <tr>
                                    <th>{{ $leave->name }}</th>
                                    <th>{{ $leave->leave_from }}</th>
                                    <th>{{ $leave->leave_till }}</th>
                                    <th>{{ $leave->reason }}</th>
                                    <th>
                                        On Process
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