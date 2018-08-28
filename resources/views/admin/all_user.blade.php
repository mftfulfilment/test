@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User List</div>

                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="col-md-12">
                                <table id="example" class="table table-hover table-responsive" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Sainik No</th>
                                        <th>Name</th>
                                        <th>Rank</th>
                                        <th>Unit</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                   {{-- <tfoot>
                                    <tr>
                                        <th>Sainik No</th>
                                        <th>Name</th>
                                        <th>Rank</th>
                                        <th>Unit</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>--}}
                                    <tbody>
                                    @foreach($user_data as $user)
                                        <tr>
                                            <th>{{ $user->sainik_no }}</th>
                                            <th>{{ $user->name }}</th>
                                            <th>{{ $user->rank }}</th>
                                            <th>{{ $user->unit }}</th>
                                            <th>{{ $user->address }}</th>
                                            <th>
                                                <a href="{{url('admin/profile/'.$user->id)}}" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></a>
                                               {{-- <a href="{{url('admin/pr')}}" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>--}}
                                                <a href="{{url('admin/change_password/'.$user->id)}}" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
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
    <script src="{{ asset('public/js/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection