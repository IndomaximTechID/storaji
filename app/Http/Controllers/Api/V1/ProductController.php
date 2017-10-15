<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductType;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function get(Request $request){
        $product = Product::with('type')->get();

        if($this->content['data'] = $product){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function find(Request $request){
        $product = Product::with('type')->find($request->id);

        if($this->content['data'] = $product){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function add(Request $request)
    {   
        $product = Product::create([
          'sku' => $request->input('sku'),
          'name' => $request->input('name'),
          'description' => $request->input('description'),
          'type_id' => ($request->input('type.id')) ? $request->input('type.id') : ProductType::create(['name' => $request->input('type')])->id,
          'stock' => $request->input('stock'),
          'cost' => $request->input('cost'),
          'selling_price' => $request->input('selling_price')
        ]);

        if($this->content['data'] = Product::with('type')->get()){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function update(Request $request)
    {
        $product = Product::with('type')->find($request->id);
        
        $product->update([
          'sku' => $request->input('sku'),
          'name' => $request->input('name'),
          'description' => $request->input('description'),
          'type_id' => ($request->input('type.id')) ? $request->input('type.id') : ProductType::create(['name' => $request->input('type')])->id,
          'stock' => $request->input('stock'),
          'cost' => $request->input('cost'),
          'selling_price' => $request->input('selling_price')
        ]);

        if($this->content['data'] = Product::with('type')->find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function delete(Request $request)
    {
        $product = Product::with('type')->find($request->id);
        
        $product->delete();

        if($this->content['data'] = Product::with('type')->find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }
}
