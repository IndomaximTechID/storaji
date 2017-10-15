<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function get(Request $request){
        $customer = Customer::get();

        if($this->content['data'] = $customer){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function find(Request $request){
        $customer = Customer::find($request->id);

        if($this->content['data'] = $customer){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function add(Request $request)
    {
        $customer = Customer::create([
          'full_name' => $request->input('full_name'),
          'company_name' => $request->input('company_name'),
          'email' => $request->input('email'),
          'address' => $request->input('address'),
          'postal_code' => $request->input('postal_code'),
          'city' => $request->input('city'),
          'country' => $request->input('country')
        ]);

        if($this->content['data'] = Customer::get()){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        
        $customer->update([
          'full_name' => $request->input('full_name'),
          'company_name' => $request->input('company_name'),
          'email' => $request->input('email'),
          'address' => $request->input('address'),
          'postal_code' => $request->input('postal_code'),
          'city' => $request->input('city'),
          'country' => $request->input('country')
        ]);

        if($this->content['data'] = Customer::find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function delete(Request $request)
    {
        $customer = Customer::find($request->id);
        
        $customer->delete();

        if($this->content['data'] = Customer::find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }
}
