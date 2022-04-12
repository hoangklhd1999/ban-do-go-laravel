@extends('layout')
@section('content')

    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="login-form">
                        <h2>Đăng nhập</h2>
                        <form action="{{ URL::to('/login-customer-to-pay') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="email_account" placeholder="Tài khoản" required="" />
                            <input type="password" name="password_account" placeholder="Password" required="" />
                            <span>
                                <input type="checkbox" class="checkbox">
                                Ghi nhớ đăng nhập
                            </span>
                            <button type="submit" class="btn btn-default">Đăng nhập</button>
                        </form>
                    </div>
                    <!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">Hoặc</h2>
                </div>
                <div class="col-sm-3">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>Đăng ký</h2>
                        <form action="{{ URL::to('/add-customer-to-pay') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="customer_name" placeholder="Họ và tên" required="" />
                            <input type="email" name="customer_email" placeholder="Địa chỉ email" required="" />
                            <input type="password" name="customer_password" placeholder="Mật khẩu" required="" />
                            <input type="text" name="customer_phone" placeholder="Phone" required="" />
                            <button type="submit" class="btn btn-default">Đăng ký</button>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li style="color: red;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
    <!--/form-->

@endsection
