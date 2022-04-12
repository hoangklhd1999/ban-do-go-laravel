<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
// use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Cart;

session_start();
class CartController extends Controller
{

    public function save_cart(Request $request)
    {
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('product')->where('product_id', $productId)->first();


        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // Cart::destroy();
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        // Cart::destroy();
        return Redirect::to('/show-cart');
    }
    public function save_cart_now(Request $request)
    {
        $productId = $request->productid_hidden;
        // $quantity = $request->qty;
        $product_info = DB::table('product')->where('product_id', $productId)->first();


        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // Cart::destroy();
        $data['id'] = $product_info->product_id;
        $data['qty'] = 1;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        // Cart::destroy();
        return Redirect::to('/show-cart');
    }
    public function show_cart()
    {

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        // $brand_product = DB::table('brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();
        
        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function delete_to_cart($rowId)
    {
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }
}
