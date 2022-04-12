<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
// use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class HomeController extends Controller
{
    public function index()
    {

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        // $brand_product = DB::table('brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();

        $all_product = DB::table('product')->where('product_status', '0')->orderby('product_id', 'desc')->limit(6)->get();

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product);
    }
    public function search(Request $request)
    {

        $keywords = $request->keywords_submit;

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();

        $search_product = DB::table('product')->where('product_name', 'like', '%' . $keywords . '%')->get();


        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product);
    }
}
