<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
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
      return response()->json(Auth::user()->toArray());
    }
}
