<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{
    public function view_order_history()
    {

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $customer_id = Session::get('customer_id');
        $all_order = DB::table('order')
            ->join('customers', 'order.customer_id', '=', 'customers.customer_id')
            ->select('order.*', 'customers.customer_name')
            ->orderby('customers.customer_id', 'desc')->where("customers.customer_id", '=', $customer_id)->where("order_type", '=', 'đang giao')->get();
        return view('pages.orderHistory.order_history')->with('category', $cate_product)->with('brand', $brand_product)->with('all_history', $all_order);
    }
    public function view_order_history1()
    {

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $customer_id = Session::get('customer_id');
        $all_order = DB::table('order')
            ->join('customers', 'order.customer_id', '=', 'customers.customer_id')
            ->select('order.*', 'customers.customer_name')
            ->orderby('customers.customer_id', 'desc')->where("customers.customer_id", '=', $customer_id)->where("order_type", '=', 'đã giao')->get();
        return view('pages.orderHistory.order_history1')->with('category', $cate_product)->with('brand', $brand_product)->with('all_history', $all_order);
    }
    public function view_order($orderId)
    {
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        $order_by_id = DB::table('order_details')
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->join('shipping', 'order.shipping_id', '=', 'shipping.shipping_id')
            ->join('customers', 'order.customer_id', '=', 'customers.customer_id')
            ->select('order.*', 'customers.*', 'shipping.*', 'order_details.*')->Where("order_details.order_id", "=", $orderId)->get();
            // dd($order_by_id);
        return view('pages.orderHistory.order_detail')->with('category', $cate_product)->with('brand', $brand_product)->with('order_by_id', $order_by_id);
    }
}
