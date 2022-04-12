<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();
class CustomerController extends Controller
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
    public function all_customers()
    {
        $this->AuthLogin();
        $all_customers = DB::table('customers')->paginate(5);
        return view('admin.view_customers')->with('all_customers', $all_customers);
    }
    public function unactive_customer($customer_id)
    {
        $this->AuthLogin();
        DB::table('customers')->where('customer_id', $customer_id)->update(['customer_status' => 1]);
        Session::put('message', 'ngừng kích hoạt tài khoản thành công');
        return Redirect::to('all-customers');
    }
    public function active_customer($customer_id)
    {
        $this->AuthLogin();
        DB::table('customers')->where('customer_id', $customer_id)->update(['customer_status' => 0]);
        Session::put('message', 'ngừng kích hoạt tài khoản thành công');
        return Redirect::to('all-customers');
    }
    public function delete_customer($customer_id)
    {
        $this->AuthLogin();
        DB::table('customers')->where('customer_id', $customer_id)->delete();
        Session::put('message', 'Xóa tài khoản thành công');
        return Redirect::to('all-customers');
    }
}
