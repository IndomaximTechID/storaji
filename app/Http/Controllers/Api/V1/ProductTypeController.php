<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\ProductType;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function get(Request $request){
        $product = ProductType::get();

        if($this->content['data'] = $product){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }

    public function find(Request $request){
        $product = ProductType::find($request->id);

        if($this->content['data'] = $product){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status']);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status']);
    }
}
