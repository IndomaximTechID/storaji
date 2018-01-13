<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function __construct(){
        $this->content = array();
    }

    public function stats(Request $request){
        $products = DB::table('products')->where('company_id', Auth::user()->company->id)->count();
        $customers = DB::table('customers')->where('company_id', Auth::user()->company->id)->count();
        $orders = DB::table('orders')->where('company_id', Auth::user()->company->id)->whereNull('deleted_at')->count();

        $product_amounts = DB::table('order_details')
                 ->join('products', 'order_details.product_id', '=', 'products.id')
                 ->join('orders', 'order_details.order_id', '=', 'orders.id')
                 ->where([
                   'products.company_id' => Auth::user()->company->id,
                   'orders.deleted_at' => null
                  ])
                 ->select(DB::raw('product_id, count(product_id) as unit, amount'))
                 ->groupBy('product_id')
                 ->get();
        
        $stats = (object) [
          'cost' => 0,
          'revenue' => 0,
          'profit' => 0
        ];

        foreach ($product_amounts as $index) {
          $pre = DB::table('products')
                     ->where('company_id', Auth::user()->company->id)
                     ->find($index->product_id);
          $cost = ($pre->cost * $index->unit) * ($pre->stock + $index->amount);
          $revenue = ($pre->selling_price * $index->unit) * $index->amount;
          $stats->cost += $cost;
          $stats->revenue += $revenue;
          $stats->profit += $revenue - $cost;
        }

        if($this->content['data'] = [
          'products' => $products,
          'customers' => $customers,
          'orders' => $orders,
          'stats' => $stats,
        ]){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }

    public function topProducts(Request $request){
        $top_products = DB::table('order_details')
                 ->join('products', 'order_details.product_id', '=', 'products.id')
                 ->join('orders', 'order_details.order_id', '=', 'orders.id')
                 ->where([
                   'products.company_id' => Auth::user()->company->id,
                   'orders.deleted_at' => null
                  ])
                 ->select(DB::raw('products.id, products.name, products.stock, count(product_id) as orders, sum(amount) as sold'))
                 ->orderBy('sold', 'desc')
                 ->groupBy('product_id')
                 ->take(5)
                 ->get();

        if($this->content['data'] = $top_products){
          $this->content['status'] = 200;
          return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
        }

        $this->content['error'] = "Server Error";
        $this->content['status'] = 500;

        return response()->json($this->content, $this->content['status'], [], JSON_NUMERIC_CHECK);
    }
}
