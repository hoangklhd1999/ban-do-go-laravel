@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>


            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>


                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_by_id as $key => $value)
                            <tr>
                                <td>{{ $value->customer_name }}</td>
                                <td>{{ $value->customer_phone }}</td>
                            </tr>
                        @break
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <br>
    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển
            </div>


            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th>Tên người vận chuyển</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>


                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>


                            @foreach ($order_by_id as $key => $value)
                        <tr>
                            <td>{{ $value->shipping_name }}</td>
                            <td>{{ $value->shipping_address }}</td>
                            <td>{{ $value->shipping_phone }}</td>
                        </tr>
                        @break
                        @endforeach


                        </tr>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <br><br>
    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">

                </div>
                <div class="col-sm-4">
                </div>
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>

                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($order_by_id as $key => $value)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->product_sales_quantity }}</td>
                                <td>{{ $value->product_price }}</td>
                                <td>{{ $value->product_price * $value->product_sales_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <footer class="panel-footer">


                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    @foreach ($order_by_id as $key => $value)
                        <form role="form" action="{{ URL::to('/save-type-order/' . $value->order_id) }}" method="post">
                            {{ csrf_field() }}

                            <div class="col-sm-7 text-right text-center-xs">
                                <select class="input-sm form-control w-sm inline v-middle" name="status">
                                    <option value="chưa giao">Chưa giao </option>
                                    <option value="đang giao">Đang giao </option>
                                    <option value="đã giao">Đã giao </option>
                                </select>
                                <button class="btn btn-sm btn-default">Xử lý</button>
                            </div>
                    @break
                    @endforeach
                    </form>
                </div>
            </footer>
        </div>
    </div>
@endsection
