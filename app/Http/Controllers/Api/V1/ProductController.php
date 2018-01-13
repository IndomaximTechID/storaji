<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductType;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class ProductController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function get(Request $request){
        $product = Product::with('type')
                            ->where('company_id', Auth::user()->company->id);
        
        if($request->has('filter')){
            $params = (object) json_decode($request->filter, true);
            
            if(is_array($params->type)){
                $params->type = (object) $params->type;
            }
            if(is_array($params->date_range)){
                $params->date_range = (object) $params->date_range;
            }
            if($params->name){
                $product = $product->where('name', 'like', '%' . $params->name . '%');
            }
            if($params->sku){
                $product = $product->where('sku', 'like', '%' . $params->sku . '%');
            }
            if(is_object($params->type) && $params->type->id){
                $product = $product->where('type_id', $params->type->id);
            }
            if(is_object($params->date_range) && ($params->date_range->from && $params->date_range->to)){
                $product = $product->whereBetween('created_at', [
                    Carbon::createFromFormat('m/d/Y', $params->date_range->from)->format('Y-m-d')." 00:00:00",
                    Carbon::createFromFormat('m/d/Y', $params->date_range->to)->format('Y-m-d')." 23:59:59"
                ]);
            }
        }

        if($this->content['data'] = $product->get()){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function find(Request $request){
        $product = Product::with('type', 'sold')
                            ->where('company_id', Auth::user()->company->id)
                            ->find($request->id);

        if($this->content['data'] = $product){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function customers(Request $request){
        $product_id = $request->id;
        $customers = Customer::whereHas('order', function($query) use ($product_id) {
                                $query->whereHas('order_detail', function($query) use ($product_id) {
                                    $query->where('product_id', $product_id);
                                });
                            })->get();

        if($this->content['data'] = $customers){
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
          'selling_price' => $request->input('selling_price'),
          'company_id' => Auth::user()->company->id
        ]);

        if($this->content['data'] = Product::with('type')->where('company_id', Auth::user()->company->id)->get()){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function update(Request $request)
    {
        $product = Product::with('type')
                            ->where('company_id', Auth::user()->company->id)
                            ->find($request->id);
        
        $product->update([
          'sku' => $request->input('sku'),
          'name' => $request->input('name'),
          'description' => $request->input('description'),
          'type_id' => ($request->input('type.id')) ? $request->input('type.id') : ProductType::create(['name' => $request->input('type')])->id,
          'stock' => $request->input('stock'),
          'cost' => $request->input('cost'),
          'selling_price' => $request->input('selling_price'),
          'image' => $request->input('image')
        ]);

        if($this->content['data'] = Product::with('type')->where('company_id', Auth::user()->company->id)->find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function delete(Request $request)
    {
        $product = Product::with('type')
                            ->where('company_id', Auth::user()->company->id)
                            ->find($request->id);
        
        $product->delete();

        if(!$this->content['data'] = Product::with('type')->where('company_id', Auth::user()->company->id)->find($request->id)){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }
}
