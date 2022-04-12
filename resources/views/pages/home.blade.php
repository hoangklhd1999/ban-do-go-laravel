@extends('layout')
@section('content')
    <div class="features_items">
        <!--features_items-->
        <h2 class="title text-center">Sản phẩm mới nhất</h2>
        @foreach ($all_product as $key => $product)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    @if ($product->product_number > 0)
                    <a href="{{ URL::to('/chi-tiet-san-pham/' . $product->product_slug) }}">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ URL::to('uploads/product/' . $product->product_image) }}" alt="" />
                                <h2>{{ number_format($product->product_price) . ' ' . 'VNĐ' }}</h2>
                                <p>{{ $product->product_name }}</p>
                                <!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ
                                    hàng</a> -->
                            </div>

                        </div>
                    </a>
                    <form action="{{ URL::to('/save-cart-now') }}" method="POST" class="text-center">
                        {{ csrf_field() }}
                        <input name="productid_hidden" type="hidden" value="{{ $product->product_id }}" />
                        <button class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ
                                        hàng</button>
                    </form>
                    @else
                    <a href="{{ URL::to('/chi-tiet-san-pham/' . $product->product_slug) }}">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ URL::to('uploads/product/' . $product->product_image) }}" alt="" />
                                <h2>{{ number_format($product->product_price) . ' ' . 'VNĐ' }}</h2>
                                <p>{{ $product->product_name }}</p>
                                <a href="#" onclick="funcHetHang();" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ
                                    hàng</a>
                            </div>

                        </div>
                    </a>
                    <script type="text/javascript">
                        function funcHetHang(){
                            alert('Sản phẩm này trong kho đã hết')
                        }
                    </script>
                    @endif
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!--features_items-->
    <!--/recommended_items-->
@endsection
