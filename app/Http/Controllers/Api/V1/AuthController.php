<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Company;
use App\CompanyType;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function login(Request $request){
        if(Auth::attempt([
          'email' => $request->input('email'),
          'password' => $request->input('password')
        ])){
            $user = Auth::user();
            $this->content['token'] =  $user->createToken($user->name . ' App')->accessToken;
            $status = 200;
        }
        else{
            $this->content['error'] = "Unauthorized";
            $status = 401;
        }
        return response()->json($this->content, $status);
    }

    public function register(Request $request){
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $company = Company::create([
            'name' => $request->input('company.name'),
            'user_id' => $user->id,
            'type_id' => ($request->input('company.type.id')) ? $request->input('company.type.id') : CompanyType::create(['name' => $request->input('company.type')])->id
        ]);

        if(Auth::attempt([
          'email' => $request->input('email'),
          'password' => $request->input('password')
        ])){
            $user = Auth::user();
            $this->content['token'] =  $user->createToken($user->name . ' App')->accessToken;
            $status = 200;
        }
        else{
            $this->content['error'] = "Unauthorized";
            $status = 401;
        }
        return response()->json($this->content, $status);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if($user->oatoken()->delete()){
            $this->content['message'] = 'success';
            $status = 200;
        }else{
            $this->content['message'] = 'error';
            $status = 500;
        }

        return response()->json($this->content, $status);
    }

    public function detail()
    {
        $user = Auth::user();
        return response()->json($user->load('company')->toArray());
    }
}
