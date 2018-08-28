<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave;
use DB;
class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    #get and display all leave type and it's limit
    public function view_setting(){
        $leave_list = Leave::all();
        return view('leave.setting_view',compact('leave_list','leave_list'));
    }

    #add new leave type
    public  function  add_leave(Request $request){
        $this->validate_req($request);
        $this->inset_leave($request->all());
        return redirect()->route('add_leave')->with('status', 'New Leave Add successfully');
    }

    #insert leave data
    protected function inset_leave(array $data){
        return Leave::create([
            'name' => $data['name'],
            'limit' => $data['limit']
        ]);
    }

    #validation leave name and it's min length & Leave limit
    protected function validate_req(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|unique:leave_type',
            'limit' => 'required'
        ]);
    }

    #display new leave add form
    public function leave_add_form(){
        return view('leave.leave_type_form');
    }

    #view leave application list
    public function get_leave_req_list(){
        $leave_list = DB::table('leave_history')
            ->join('users', 'users.sainik_no', '=', 'leave_history.snk_no')
            ->join('leave_type', 'leave_type.id', '=', 'leave_history.leave_no')
            ->select('leave_history.*','leave_history.id as leave_id', 'users.name as username','users.sainik_no','users.id', 'leave_type.*')
            ->where('is_read',0 )
            ->get();

        return view('leave.leave_req_list',compact('leave_list','leave_list'));
    }

    #approve leave request
    public function leave_approve(Request $request){
        $leave_id = $request->input('leave_id');
        DB::table('leave_history')
            ->where('id',$leave_id )
            ->update(['in_process' => 1,'is_approve'=>1,'is_read'=>1]);
        return redirect()->route('view_leave_req')->with('status', 'Application Approved!!!');

    }
    #cancel leave request
    public function leave_cancel(Request $request){
        $leave_id = $request->input('leave_id');
        DB::table('leave_history')
            ->where('id',$leave_id )
            ->update(['in_process' => 1,'is_approve'=>0,'is_read'=>1]);
        return redirect()->route('view_leave_req')->with('mess', "Application Doesn't Approved!!!");
    }

    #display leave history
    public function leave_history(){
        $leave_list = DB::table('leave_history')
            ->join('users', 'users.sainik_no', '=', 'leave_history.snk_no')
            ->join('leave_type', 'leave_type.id', '=', 'leave_history.leave_no')
            ->select('leave_history.*','leave_history.is_approve as approve','leave_history.id as leave_id', 'users.name as username','users.sainik_no','users.id', 'leave_type.*')
            ->where('is_read',1)
            ->get();

        return view('leave.leave_history_list',compact('leave_list','leave_list'));
    }
}
