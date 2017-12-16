<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Product;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function get(Request $request){
        $order = Order::with(['order_detail.product', 'customer'])
                        ->where('company_id', Auth::user()->company->id);

        if($request->has('filter')){
            $params = (object) json_decode($request->filter, true);

            if(is_array($params->date_range)){
                $params->date_range = (object) $params->date_range;
            }
            if($params->id){
                $order = $order->where('id', 'like', '%' . $params->id . '%');
            }
            if($params->product){
                $order = $order->whereHas('order_detail', function($q) use ($params) {
                  $q->whereHas('product', function($q) use ($params) {
                    $q->where('name', 'like', '%' . $params->product . '%');
                  });
                });
            }
            if($params->customer){
                $order = $order->whereHas('customer', function($q) use ($params) {
                  $q->where('full_name', 'like', '%' . $params->customer . '%');
                });
            }

            if(is_object($params->date_range) && ($params->date_range->from && $params->date_range->to)){
                $customer = $customer->whereBetween('created_at', [
                    Carbon::createFromFormat('m/d/Y', $params->date_range->from)->format('Y-m-d')." 00:00:00",
                    Carbon::createFromFormat('m/d/Y', $params->date_range->to)->format('Y-m-d')." 23:59:59"
                ]);
            }
        }

        if($this->content['data'] = $order->get()){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function find(Request $request){
        $order = Order::with(['order_detail.product', 'customer'])
                      ->where('company_id', Auth::user()->company->id)
                      ->find($request->id);

        if($this->content['data'] = $order){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function add(Request $request)
    {
        $product = Product::find($request->input('order_detail.product.id'));
        if ($product->stock >= $request->input('order_detail.amount')){
          $product->update([
            'stock' => (int) $product->stock - $request->input('order_detail.amount')
          ]);
          
          $order = Order::create([
            'customer_id' => $request->input('customer.id'),
            'company_id' => Auth::user()->company->id
          ]);
  
          $order_detail = OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'amount' => $request->input('order_detail.amount')
          ]);

          if($this->content['data'] = Order::with(['order_detail.product', 'customer'])->where('company_id', Auth::user()->company->id)->get()){
            $this->content['status'] = 200;
            return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
          }
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }
}
