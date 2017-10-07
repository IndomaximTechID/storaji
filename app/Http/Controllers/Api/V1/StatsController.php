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
        $products = DB::table('products')->count();
        $customers = DB::table('customers')->count();
        $orders = DB::table('orders')->count();

        $product_amounts = DB::table('order_details')
                 ->join('products', 'order_details.product_id', '=', 'products.id')
                 ->select(DB::raw('product_id, count(product_id) as amount'))
                 ->groupBy('product_id')
                 ->get();
        
        $stats = (object) [
          'cost' => 0,
          'revenue' => 0,
          'profit' => 0
        ];

        foreach ($product_amounts as $index) {
          $pre = DB::table('products')
                 ->find($index->product_id);
          $stats->cost += $pre->cost * $index->amount;
          $stats->revenue += $pre->selling_price * $index->amount;
          $stats->profit += ($pre->selling_price * $index->amount) - ($pre->cost * $index->amount);
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
}
