<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Leave;
use App\User;
use Carbon\Carbon;

class User_Management extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    #view profile info
    public function profile_info(){
        return view('user.profile');
        /*echo Auth::user()->sainik_no;*/
    }
    #update profile info
    public function profile_update(){

    }

    #get get request for leave form show
    public function leave_apply(){
        $snk_no = Auth::user()->sainik_no;

        /*Take Leave list*/
        $leave_list = Leave::all();

        /*$leave_taken hold those rows which leaves are taken*/
        $leave_taken = DB::table('leave_history')
            ->join('leave_type', 'leave_type.id', '=', 'leave_history.leave_no','RIGHT')
            ->select('leave_type.id','leave_type.name','leave_type.limit',DB::raw("SUM(DATEDIFF(leave_history.leave_till,leave_history.leave_from)) as take"))
            ->groupBy('leave_type.id')
            ->where('leave_history.snk_no',$snk_no)
            ->where('leave_history.is_approve' , 1)
            ->whereBetween('leave_history.leave_from', array(DB::raw(DATE_FORMAT(Carbon::now(),'Y-01-01')), DB::raw(DATE_FORMAT(Carbon::now(),'Y-12-31'))))
            ->get();

        /*$leave_not_taken hold those rows which leaves are not taken*/
        $leave_not_taken = DB::table('leave_type')->whereNotIn('id', function($q){
                $q->select('leave_type.id')
                ->join('leave_history', 'leave_type.id', '=', 'leave_history.leave_no','from leave_type left')
                ->groupBy('leave_type.id')
                ->where('leave_history.snk_no',Auth::user()->sainik_no)
                ->where('leave_history.is_approve' , 1)
                ->whereBetween('leave_history.leave_from', array(DB::raw(DATE_FORMAT(Carbon::now(),'Y-01-01')), DB::raw(DATE_FORMAT(Carbon::now(),'Y-12-31'))))
                ->get();
        })->get();

        /*$leave_taken and $leave_not_taken both are hold the leave status*/

        return view('user.leave_form')->with('leave_not_taken',$leave_not_taken)->with('leave_list',$leave_list)->with('leave_taken',$leave_taken);
    }

    #get the post request from leave
    public function apply_to_leave(Request $request){

        $this->validate_req($request);

        $snk_no = Auth::user()->sainik_no;

        $leave_no = $request->input('leave_no');
        $leave_from = $request->input('leave_from');
        $leave_till = $request->input('leave_till');
        $reason = $request->input('reason');
        $days = $this->get_days_btw_date($leave_from,$leave_till);
        $remaining_days = $this->get_days($leave_no);

        $is_pending = $this->get_pending_req($snk_no);
        if($is_pending!=null){
            return redirect()->route('leave_apply')->with('mess', 'Already a request pending');
        }
        if($days > $remaining_days){
            return redirect()->route('leave_apply')->with('mess', 'Sorry, You are crossing the limit');
        }

        DB::table('leave_history')->insert(
            ['snk_no' => $snk_no,
            'leave_no' => $leave_no,
            'leave_from' => $leave_from,
            'leave_till' => $leave_till,
            'reason' => $reason,
            'in_process' => 0,
            'is_approve' => 0,
            'is_read' => 0,]
        );

        return redirect()->route('leave_process')->with('status', 'Leave Application Send Successfully');

    }


    #check validation of request
    protected function validate_req(Request $request)
    {
        $this->validate($request, [
            'leave_no' => 'required|between:1,99',
            'leave_from' => 'date_format:"Y-m-d"|required|after:today',
            'leave_till' => 'date_format:"Y-m-d"|required|after:leave_from',
            'reason' => 'required|string',
        ]);
    }
    #leave history of user
    public function leave_history(){
        $sainik_no = Auth::user()->sainik_no;
        $leave_list = DB::table('leave_history')
            ->join('users', 'users.sainik_no', '=', 'leave_history.snk_no')
            ->join('leave_type', 'leave_type.id', '=', 'leave_history.leave_no')
            ->select('leave_history.*','leave_history.is_approve as approve','leave_history.id as leave_id', 'users.name as username','users.sainik_no','users.id', 'leave_type.*')
            ->where('is_read',1)
            ->where('sainik_no',$sainik_no)
            ->get();
        return view('user.user_leave_history',compact('leave_list','leave_list'));
    }

    #leave processing list
    public function leave_process(){
        $sainik_no = Auth::user()->sainik_no;
        $leave_list = DB::table('leave_history')
            ->join('users', 'users.sainik_no', '=', 'leave_history.snk_no')
            ->join('leave_type', 'leave_type.id', '=', 'leave_history.leave_no')
            ->select('leave_history.*','leave_history.is_approve as approve','leave_history.id as leave_id', 'users.name as username','users.sainik_no','users.id', 'leave_type.*')
            ->where('is_read',0)
            ->where('sainik_no',$sainik_no)
            ->get();
        return view('user.leave_process_list',compact('leave_list','leave_list'));
    }

    #password update form
    public function show_password_update_form(){
        return view('user.password_update');
    }

    #update upser password
    public function password_update(Request $request){
        $sainik_no = Auth::user()->sainik_no;
        $this->validate_password($request);
        User::where('sainik_no',$sainik_no)
            ->update(['password' => bcrypt($request['password'])]);
        return redirect()->route('password_update')->with('status', 'User password successfully update');
    }

    #validation password is confirmed or not and min length
    protected function validate_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    #return remaining days by leave id
    private function get_days($id){
        $limit = DB::table('leave_type')
            ->select('limit')
            ->where('id',$id )
            ->first();

        /*$leave_taken hold those rows which leaves are taken*/
        $leave_taken = DB::table('leave_history')
            ->join('leave_type', 'leave_type.id', '=', 'leave_history.leave_no','RIGHT')
            ->select(DB::raw("SUM(DATEDIFF(leave_history.leave_till,leave_history.leave_from)) as take"))
            ->groupBy('leave_type.id')
            ->where('leave_history.snk_no',Auth::user()->sainik_no)
            ->where('leave_history.is_approve' , 1)
            ->where('leave_type.id' , $id)
            ->whereBetween('leave_history.leave_from', array(DB::raw(DATE_FORMAT(Carbon::now(),'Y-01-01')), DB::raw(DATE_FORMAT(Carbon::now(),'Y-12-31'))))
            ->get();

            if(sizeof($leave_taken)>0){
                return $limit-$leave_taken[0]->take;
            }else{
                return $limit->limit;
            }
    }

    #return pending leave
    private function get_pending_req($snk_no){
        $pending = DB::table('leave_history')
            ->select('*')
            ->where('leave_history.snk_no',$snk_no)
            ->where('in_process',0 )
            ->get();

        return $pending;
    }

    #get days between tow date
    private function get_days_btw_date($leave_from,$leave_till){
        $date1=date_create($leave_from);
        $date2=date_create($leave_till);
        $diff=date_diff($date1,$date2);
        return $diff->format("%a");
    }
}