<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Cart;
// use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\checkRegistrationk;
use App\Http\Requests\CheckShipping;

session_start();

class CheckoutController extends Controller
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
    public function view_order($orderId)
    {
        $this->AuthLogin();
        $order_by_id = DB::table('order_details')
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->join('shipping', 'order.shipping_id', '=', 'shipping.shipping_id')
            ->join('customers', 'order.customer_id', '=', 'customers.customer_id')
            ->select('order.*', 'customers.*', 'shipping.*', 'order_details.*')->Where("order_details.order_id", "=", $orderId)->get();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
    public function login_checkout()
    {
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function login_checkout_to_pay()
    {

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.login_to_payment')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function add_customer(checkRegistrationk $request)
    {

        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = DB::table('customers')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect::to('/');
    }
    public function add_customer_to_pay(checkRegistrationk $request)
    {

        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = DB::table('customers')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect::to('/checkout');
    }
    public function checkout()
    {
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();

        return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function save_checkout_customer(CheckShipping $request)
    {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;

        $shipping_id = DB::table('shipping')->insertGetId($data);

        Session::put('shipping_id', $shipping_id);

        return Redirect::to('/payment');
    }
    public function payment()
    {

        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();
        return view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product);
    }
    public function order_place(Request $request)
    {
        //insert payment_method

        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = str_replace('.00','',Cart::total());
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_data['order_type'] = 'chưa giao';
        $order_data['order_date'] = date('Y-m-d H:i:s');
        $order_id = DB::table('order')->insertGetId($order_data);
        //insert order_details
        $content = Cart::content();
        foreach ($content as $v_content) {
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('order_details')->insert($order_d_data);
        }
        if ($data['payment_method'] == 1) {

            echo 'Thanh toán thẻ ATM';
        } elseif ($data['payment_method'] == 2) {
            Cart::destroy();

            $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('product')->select('brand.*', DB::raw('count(product_id) as brand_product_qty'))
        ->join('category_product','category_product.category_id','=','product.category_id')
        ->join('brand','brand.brand_id','=','product.brand_id')
        ->groupBy('brand_id')->orderBy('brand_id', 'desc')->get();
            return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product);
        } else {
            echo 'Thẻ ghi nợ';
        }

        //return Redirect::to('/payment');        
    }
    public function logout_checkout()
    {
        Session::flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('customers')->where('customer_email', $email)->where('customer_password', $password)->first();
        if ($result) {
            Session::put('customer_id', $result->customer_id);
            // return Redirect::to('/checkout');
            return Redirect::to('/');

        } else {
            return Redirect::to('/login-checkout');
        }
    }
    public function login_customer_to_pay(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('customers')->where('customer_email', $email)->where('customer_password', $password)->first();
        if ($result) {
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');

        } else {
            return Redirect::to('/login-to-payment');
        }
    }
    public function manage_order()
    {

        $this->AuthLogin();
        $all_order = DB::table('order')
            ->join('customers', 'order.customer_id', '=', 'customers.customer_id')
            ->select('order.*','customers.customer_name')
            ->orderby('order.order_id', 'desc')->where("order_status", '=', 'Đang chờ xử lý')->paginate(5);
        $manager_order  = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
    public function manage_order1()
    {

        $this->AuthLogin();
        $all_order = DB::table('order')
            ->join('customers', 'order.customer_id', '=', 'customers.customer_id')
            ->select('order.*', 'customers.customer_name')
            ->orderby('order.order_id', 'desc')->where("order_status", '=', 'Đã xử lý')->paginate(5);
        $manager_order  = view('admin.manage_order1')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order1', $manager_order);
    }
    public function delete_order($orderId)
    {
        $this->AuthLogin();
        DB::table('order')->where('order_id', $orderId)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('manage-order');
    }
    public function delete_order1($orderId)
    {
        $this->AuthLogin();
        DB::table('order')->where('order_id', $orderId)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('manage-order1');
    }
    public function save_type_order(Request $request, $order_id)
    {
        $this->AuthLogin();
        $data = array();    
        $data['order_type'] = $request->status;
        $data['order_status'] = 'Đã xử lý';
        DB::table('order')->where('order_id', $order_id)->update($data);
        // Session::put('message','Đã xử lý đơn hàng');
        return Redirect::to('manage-order1');
    }
}
