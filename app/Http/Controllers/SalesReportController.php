<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
// use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();
class SalesReportController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function overview_report()
    {
        $this->AuthLogin();
        $all_money = DB::table('order_details')
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->join('product', 'order_details.product_id', '=', 'product.product_id')
            ->select('product.product_id', DB::raw('SUM(order.order_total) as total_price'))->groupBy('product_id');

        $all_prd = DB::table('order_details')
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->join('product', 'order_details.product_id', '=', 'product.product_id')
            ->select('product.product_id', DB::raw('SUM(order.order_total) - SUM(product.product_number)*SUM(product.product_import_price) as total_sales'))->groupBy('product_id');





        $all_report_salerder = DB::table('brand')
            ->join('product', 'brand.brand_id', '=', 'product.brand_id')
            ->joinSub($all_money, 'all_money', function ($join) {
                $join->on('all_money.product_id', '=', 'product.product_id');
            })
            ->joinSub($all_prd, 'all_prd', function ($join) {
                $join->on('all_prd.product_id', '=', 'product.product_id');
            })
            ->select('product.*', 'brand.*', 'all_money.total_price', 'all_prd.total_sales')
            ->orderby('brand.brand_id', 'desc')->get()->groupBy('brand_name')->toArray();
        // dd($all_report_salerder);

        return view('admin.report.sales_report')->with('all_report', $all_report_salerder);
    }
}
