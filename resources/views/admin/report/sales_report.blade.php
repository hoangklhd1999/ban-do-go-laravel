@extends('admin_layout')
@section('admin_content')
    <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
            <input type="date" class="input-sm form-control w-sm inline v-middle" name="date">
            <button class="btn btn-sm btn-default">Xác nhận</button>
        </div>
    </div>
    <section class="wrapper">
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    BÁO CÁO SỐ LƯỢNG BÁN, DOANH SỐ THEO THÁNG
                </div>
                <div>
                    <table class="table" ui-jq="footable" ui-options='{
                                                                                                                "paging": {
                                                                                                                  "enabled": true
                                                                                                                },
                                                                                                                "filtering": {
                                                                                                                  "enabled": true
                                                                                                                },
                                                                                                                "sorting": {
                                                                                                                  "enabled": true
                                                                                                                }}'>
                        <thead>
                            <tr>
                                <th data-breakpoints="xs">Mã hàng</th>
                                <th>Tên hàng</th>
                                <th>Số lượng</th>
                                <th data-breakpoints="xs">Doanh số</th>
                                <th data-breakpoints="xs sm md" data-title="DOB">Doanh thu thuần</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                            @foreach ($all_report as $item => $value)
                                <tr data-expanded="true">
                                    <td colspan="5">Nguồn nhập :{{ $item }}</td>
                                </tr>
                                @foreach ($value as $item1 => $value1)
                                    <tr>
                                        <td>{{ $value1->product_id }}</td>
                                        <td>{{ $value1->product_name }}</td>
                                        <td>{{ $value1->product_number }}</td>
                                        <td>{{ $value1->total_price }}</td>
                                        @php
                                            $sales = $value1->total_sales;
                                        @endphp
                                        <td class="{{ $sales > 0 ? 'up-sales' : ($sales < 0 ? 'down-sales' : '') }}">
                                            {{ $sales }}
                                        </td>

                                    </tr>
                                @endforeach
                                <tr data-expanded="true">
                                    <td colspan="2">Cộng nhóm: nguồn nhập {{ $item }}</td>
                                    <td>
                                        <?php
                                        $sum = 0;
                                        foreach ($value as $item1 => $value1) {
                                            $sum += $value1->product_number;
                                        }
                                        echo $sum;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $sum = 0;
                                        foreach ($value as $item1 => $value1) {
                                            $sum += $value1->total_price;
                                        }
                                        echo $sum;
                                        ?>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- footer -->
    <div class="footer">
        <div class="wthree-copyright">
            <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
        </div>
    </div>
    <style>
        .up-sales {
            color: green !important;
        }

        .down-sales {
            color: red !important;
        }

    </style>
@endsection
