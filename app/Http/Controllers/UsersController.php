<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required',
            'gender' => 'required',
            'password' => 'required|min:6',
            'c_password' => 'required|min:6|same:password',
        ]);
    }

    public function index()
    {
        //
    }


protected function create(array $data)
    {
        return Users::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'password' => bcrypt($data['password']),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function login(Request $request){
        if(Auth::attempt(['email' => $request->input('email'), 'password' =>  $request->input('password')])){
            $user = Auth::user();
            // $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success[$user['token']] = Str::random(40);
            $success['id'] =  $user->id;
            $success['firstName'] =  $user->firstName;
            $success['lastName'] =  $user->lastName;
            $success['email'] =  $user->email;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Sorry! You are Unauthorised to login '], 401);
        }
    }



    public function register(Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);
        if ($validator->passes()) {
            $user = $this->create($input)->toArray();
            $user['link'] = Str::random(40);
            DB::table('user_activations')->insert(['id_user' => $user['id'], 'token' => $user['link']]);
            Mail::send('emails.activation', $user, function ($message) use ($user) {
                $message->to($user['email']);
                $message->subject('Activation Code');
            });
            return( "We sent you an activation code. Please check your mail.");
        }
        return( "Error");
    }



    public function userActivation($token)
    {
        $check = DB::table('user_activations')->where('token', $token)->first();
        if (!is_null($check)) {
            $user = Users::find($check->id_user);
            if ($user->is_activated == 1) {
                return ( "user Account is already activated.");
            }
            $user->update(['is_activated' => 1]);
            DB::table('user_activations')->where('token', $token)->delete();
            return( "Your Account has been activated successfully.");
        }
        return ("your Activation Key is invalid");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $users)
    {
        //
    }
}
