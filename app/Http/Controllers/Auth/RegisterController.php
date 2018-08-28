<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;



    protected function redirectTo(){
        return redirect('/admin/make_user')->with('status', 'User successfully Created!');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/make_user';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'sainik_no' => 'required|string|max:255|unique:users',
            'rank' => 'required|string',
            'name' => 'required|string',
            'unit' => 'required|string',
            'profile_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data,$file_name)
    {

        return User::create([
            'sainik_no' => $data['sainik_no'],
            'rank' => $data['rank'],
            'name' => $data['name'],
            'unit' => $data['unit'],
            'profile_image' => $file_name,
            'address' => $data['address'],
            'password' => bcrypt($data['password']),
        ]);
    }


    #profile image upload
    protected function fileUpload(Request $request)
    {

        $image = $request->file('profile_img');

        $image_name = time().'_'.$image->getClientOriginalName();

        $destinationPath = public_path('/profile');

        $image->move($destinationPath, $image_name);

        return $image_name;

        /*$this->postImage->add($input);


        return back()->with('success','Image Upload successful');*/

    }
}
