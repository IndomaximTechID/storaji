<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use App\Company;
use App\CompanyType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function updateProfile(Request $request)
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        if($user->update([
            'name' => $request->input('name') && !empty($request->input('name'))
                            ? $request->input('name')
                            : $auth->name,
            'email' => $request->input('email') && !empty($request->input('email'))
                            ? $request->input('email')
                            : $auth->email,
            'password' => $request->input('password') && !empty($request->input('password'))
                            ? !Hash::check($request->input('old_password'), $user->password)
                                ? $user->password
                                : bcrypt($request->input('password'))
                            : $user->password,
        ])) {
          $this->content['data'] = User::with('company')->find($auth->id);
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }
}
