<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function get(Request $request){
        $customer = Customer::where('company_id', Auth::user()->company->id);
        
        if($request->has('filter')){
            $params = (object) json_decode($request->filter, true);

            if(is_array($params->date_range)){
                $params->date_range = (object) $params->date_range;
            }
            if($params->name){
                $customer = $customer->where('full_name', 'like', '%' . $params->name . '%');
            }
            if($params->company){
                $customer = $customer->where('company_name', 'like', '%' . $params->company . '%');
            }
            if($params->city){
                $customer = $customer->where('city', 'like', '%' . $params->city . '%');
            }
            if($params->country){
                $customer = $customer->where('country', 'like', '%' . $params->country . '%');
            }

            if(is_object($params->date_range) && ($params->date_range->from && $params->date_range->to)){
                $customer = $customer->whereBetween('created_at', [
                    Carbon::createFromFormat('m/d/Y', $params->date_range->from)->format('Y-m-d')." 00:00:00",
                    Carbon::createFromFormat('m/d/Y', $params->date_range->to)->format('Y-m-d')." 23:59:59"
                ]);
            }
        }

        if($this->content['data'] = $customer->get()){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function find(Request $request){
        $customer = Customer::where('company_id', Auth::user()->company->id)->find($request->id);

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
          'country' => $request->input('country'),
          'company_id' => Auth::user()->company->id
        ]);

        if($this->content['data'] = Customer::where('company_id', Auth::user()->company->id)->get()){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function update(Request $request)
    {
        $customer = Customer::where('company_id', Auth::user()->company->id)->find($request->id);
        
        $customer->update([
          'full_name' => $request->input('full_name'),
          'company_name' => $request->input('company_name'),
          'email' => $request->input('email'),
          'address' => $request->input('address'),
          'postal_code' => $request->input('postal_code'),
          'city' => $request->input('city'),
          'country' => $request->input('country')
        ]);

        if($this->content['data'] = Customer::where('company_id', Auth::user()->company->id)->find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function delete(Request $request)
    {
        $customer = Customer::where('company_id', Auth::user()->company->id)->find($request->id);
        
        $customer->delete();

        if(!$this->content['data'] = Customer::where('company_id', Auth::user()->company->id)->find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }
}
