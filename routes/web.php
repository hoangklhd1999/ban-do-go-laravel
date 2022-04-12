<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Frontend
Route::get('/', 'HomeController@index');
Route::get('/trang-chu', 'HomeController@index');
Route::post('/tim-kiem', 'HomeController@search');

//Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{slug_category_product}', 'CategoryProduct@show_category_home');
Route::get('/thuong-hieu-san-pham/{brand_slug}', 'BrandProduct@show_brand_home');
Route::get('/chi-tiet-san-pham/{product_slug}', 'ProductController@details_product');
Route::get('/all-customers', 'CustomerController@all_customers');
Route::get('/unactive-customer/{customer_id}', 'CustomerController@unactive_customer');
Route::get('/active-customer/{customer_id}', 'CustomerController@active_customer');
Route::get('/delete-customer/{customer_id}', 'CustomerController@delete_customer');
//Backend
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::get('/logout', 'AdminController@logout');
Route::post('/admin-dashboard', 'AdminController@dashboard');

//Category Product
Route::get('/add-category-product', 'CategoryProduct@add_category_product');
Route::get('/edit-category-product/{category_product_id}', 'CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'CategoryProduct@delete_category_product');
Route::get('/all-category-product', 'CategoryProduct@all_category_product');

Route::get('/unactive-category-product/{category_product_id}', 'CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'CategoryProduct@active_category_product');


Route::post('/save-category-product', 'CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}', 'CategoryProduct@update_category_product');

//Brand Product
Route::get('/add-brand-product', 'BrandProduct@add_brand_product');
Route::get('/edit-brand-product/{brand_product_id}', 'BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}', 'BrandProduct@delete_brand_product');
Route::get('/all-brand-product', 'BrandProduct@all_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}', 'BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}', 'BrandProduct@active_brand_product');

Route::post('/save-brand-product', 'BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}', 'BrandProduct@update_brand_product');

//Product
Route::get('/add-product', 'ProductController@add_product');
Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
Route::get('/delete-product/{product_id}', 'ProductController@delete_product');
Route::get('/all-product', 'ProductController@all_product');

Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');

Route::post('/save-product', 'ProductController@save_product');
Route::post('/update-product/{product_id}', 'ProductController@update_product');


//Cart
Route::post('/update-cart-quantity', 'CartController@update_cart_quantity');
Route::post('/save-cart', 'CartController@save_cart');
Route::post('/save-cart-now', 'CartController@save_cart_now');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/delete-to-cart/{rowId}', 'CartController@delete_to_cart');

//Checkout
Route::get('/login-checkout', 'CheckoutController@login_checkout');
Route::get('/login-checkout-to-pay', 'CheckoutController@login_checkout_to_pay');
Route::get('/logout-checkout', 'CheckoutController@logout_checkout');
Route::post('/add-customer', 'CheckoutController@add_customer');
Route::post('/add-customer-to-pay', 'CheckoutController@add_customer_to_pay');
Route::post('/order-place', 'CheckoutController@order_place');
Route::post('/login-customer', 'CheckoutController@login_customer');
Route::post('/login-customer-to-pay', 'CheckoutController@login_customer_to_pay');
Route::get('/checkout', 'CheckoutController@checkout');
Route::get('/payment', 'CheckoutController@payment');
Route::post('/save-checkout-customer', 'CheckoutController@save_checkout_customer');

//Order
Route::get('/manage-order', 'CheckoutController@manage_order');
Route::get('/view-order/{orderId}', 'CheckoutController@view_order');
Route::post('/save-type-order/{order_id}', 'CheckoutController@save_type_order');
Route::get('/delete-order/{orderId}', 'CheckoutController@delete_order');
Route::get('/manage-order1', 'CheckoutController@manage_order1');


// report
Route::get('/overview-report', 'SalesReportController@overview_report');


//order history
Route::get('/order-history', 'OrderHistoryController@view_order_history');
Route::get('/order-history1', 'OrderHistoryController@view_order_history1');

Route::get('/order-detail/{orderId}', 'OrderHistoryController@view_order');
