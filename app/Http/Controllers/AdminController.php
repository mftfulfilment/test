<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }


    //Start logical operation by admin

    #get leave request from users
    public  function leave_req(){
        return "You are heare";
    }

    #create new user
    public function make_user(){
        return view('admin.create_users');
    }

    #set new password for user by id
    public function password_update($user_id,Request $request){
       $this->validate_req($request);
       User::where('id',$user_id)
           ->update(['password' => bcrypt($request['password'])]);
        return redirect()->route('profile',['id'=>$user_id])->with('status', 'User password successfully update');
    }

    #validation password is confirmed or not and min length
    protected function validate_req(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    #view all user
    public function all_users(){
        $user_data = User::all();
        return view('admin.all_user',compact('user_data','user_data'));
    }

    #view detail specific profile
    public function view_profile($id){
        $profile = User::select( 'id','sainik_no', 'rank','name','unit','profile_image','address')->where('id', $id)->first();
        $leave_list = DB::table('leave_history')
            ->join('users', 'users.sainik_no', '=', 'leave_history.snk_no')
            ->join('leave_type', 'leave_type.id', '=', 'leave_history.leave_no')
            ->select('leave_history.*','leave_history.is_approve as approve','leave_history.id as leave_id', 'users.name as username','users.sainik_no','users.id', 'leave_type.*')
            ->where('users.id',$id)
            ->orderBy('leave_history.id', 'desc')
            ->get();
        return view('admin.profile')->with('profile',$profile)->with('leave_list',$leave_list);
    }
    #update user password
    public function update_user_pass($id){
        if (is_numeric($id)){
            return view('admin.update_pass',compact('id','id'));
        }else{
            $user_data = User::all();
            return view('admin.all_user',compact('user_data','user_data'));
        }
    }

    #get days between tow date
    public static function get_days_btw_date($leave_from,$leave_till){
        $date1=date_create($leave_from);
        $date2=date_create($leave_till);
        $diff=date_diff($date1,$date2);
        echo $diff->format("%a");
    }

}
