@extends('frontend.layouts.master')

@section('title')
    {{$settings->site_name}} || Cart Details
@endsection

@section('content')
     <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>cart View</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">peoduct</a></li>
                            <li><a href="#">cart view</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->
    <!--============================
        CART VIEW PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr class="d-flex">
                                        <th class="wsus__pro_img">
                                            product item
                                        </th>

                                        <th class="wsus__pro_name">
                                            product details
                                        </th>

                                        <th class="wsus__pro_tk">
                                           unit price
                                        </th>
                                        <th class="wsus__pro_status">
                                            Total Price
                                        </th>

                                        <th class="wsus__pro_select">
                                            quantity
                                        </th>



                                        <th class="wsus__pro_icon">
                                            <a href="#" class="common_btn clear_cart">clear cart</a>
                                        </th>
                                    </tr>
                                    @foreach ($cartItems as $item)

                                        <tr class="d-flex">
                                            <td class="wsus__pro_img"><img src="{{asset($item->options->image)}}" alt="product"
                                                    class="img-fluid w-100">
                                            </td>

                                            <td class="wsus__pro_name">
                                                <p>{{$item->name}}</p>
                                                @foreach ($item->options->variants as  $key => $variants)
                                                    <span>{{$key}}: {{$variants['name']}} ({{$settings->currency_icon.$variants['price']}})</span>
                                                @endforeach
                                            </td>

                                            <td class="wsus__pro_tk">
                                                <h6>{{$settings->currency_icon.$item->price}}</h6>
                                            </td>
                                            <td class="wsus__pro_status">
                                                <h6 id="{{$item->rowId}}">{{$settings->currency_icon.($item->price + $item->options->variants_total) * $item->qty}}</h6>
                                            </td>

                                            <td class="wsus__pro_select">
                                                <div class="product_qty_wrapper">
                                                    <button class="btn btn-danger product-decrement">-</button>
                                                    <input class="product-qty" readonly data-rowid="{{$item->rowId}}" type="text" min="1" max="100" value="{{$item->qty}}" />
                                                    <button class="btn btn-success product-increment">+</button>
                                                </div>
                                            </td>


                                            <td class="wsus__pro_icon">
                                                <a href="{{route('cart.remove-product', $item->rowId)}}"><i class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($cartItems) === 0)
                                        <tr class="d-flex">
                                            <td class="wsus__pro_icon" style="width: 100%">
                                                Cart is Empty
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="sub_total">{{$settings->currency_icon}}{{getCartTotal()}}</span></p>
                        <p>discount: <span id="discount">{{$settings->currency_icon}}{{getCartDiscount()}}</span></p>
                        <p class="total"><span>total:</span> <span id="cart_total">{{$settings->currency_icon}}{{getMainCartTotal()}}</span></p>

                        <form id="coupon_form">
                            <input type="text" id="coupon_code" name="coupon_code" placeholder="Coupon Code" value="{{session()->has('coupon') ? session()->get('coupon')['coupon_code'] : ''}}">
                            <button type="submit" class="common_btn">apply</button>
                        </form>
                        <a class="common_btn mt-4 w-100 text-center" href="{{route('user.checkout')}}">checkout</a>
                        <a class="common_btn mt-1 w-100 text-center" href="{{route('home')}}"><i
                                class="fab fa-shopify"></i> Keep Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">
                            <img src="{{asset('frontend/images/single_banner_2.jpg')}}" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>sell on <span>35% off</span></h6>
                            <h3>smart watch</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            <img src="{{asset('frontend/images/single_banner_3.jpg')}}" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>New Collection</h6>
                            <h3>Cosmetics</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
          CART VIEW PAGE END
    ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Increment Quantity
            $('.product-increment').on('click', function() {
                let input = $(this).siblings('.product-qty');
                let quantity = parseInt(input.val()) + 1;
                let rowId = input.data('rowid')
                input.val(quantity);

                $.ajax({
                    url: '{{route('cart.update-quantity')}}',
                    method: "POST",
                    data: {
                        rowId: rowId,
                        quantity: quantity,
                    },
                    success: function(data) {
                        if(data.status === 'success') {
                            let productId = '#'+rowId;
                            let totalAmount = "{{$settings->currency_icon}}"+ data.product_total
                            $(productId).text(totalAmount)
                            renderCartSubtotal();
                            calculateCouponDiscount();
                            toastr.success(data.message);
                        } else if (data.status === 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {

                    }
                })
            })

            //decrement Quantity
            $('.product-decrement').on('click', function() {
                let input = $(this).siblings('.product-qty');
                let quantity = parseInt(input.val()) - 1;
                let rowId = input.data('rowid')
                if(quantity < 1) {
                    quantity = 1;
                }
                input.val(quantity);
                $.ajax({
                    url: '{{route('cart.update-quantity')}}',
                    method: "POST",
                    data: {
                        rowId: rowId,
                        quantity: quantity,
                    },
                    success: function(data) {
                        if(data.status === 'success') {
                            let productId = '#'+rowId;
                            let totalAmount = "{{$settings->currency_icon}}"+ data.product_total
                            $(productId).text(totalAmount);
                            renderCartSubtotal();
                            calculateCouponDiscount();
                            toastr.success(data.message);
                        } else if (data.status === 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {

                    }
                })
            })

            /** clear Cart */
            $('.clear_cart').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will clear your cart!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: "{{route('clear-cart')}}",
                            success: function (data) {
                                if(data.status == 'success') {
                                    Swal.fire({
                                    title: "Deleted!",
                                    text: data.message,
                                    icon: "success"
                                    });
                                    window.location.reload();
                                } else if (data.status == 'error'){
                                    Swal.fire({
                                        title: "Cant Deleted!",
                                        text: data.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhm, status, error) {
                                console.log(error);
                            }
                        });
                    }
                })
            })

            function renderCartSubtotal () {
                $.ajax({
                    method: 'GET',
                    url: "{{route('cart.sidebar-product-total')}}",
                    success: function (data) {
                        $('#sub_total').text("{{$settings->currency_icon}}"+data);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }

            /** Apply coupon */
            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    method: 'GET',
                    url: "{{route('apply-coupon')}}",
                    data: formData,
                    success: function(data) {
                        if(data.status === 'error') {
                            toastr.error(data.message);
                        } else if (data.status === 'success') {
                            calculateCouponDiscount();
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            })

            //CAlculate discount amount
            function calculateCouponDiscount () {
                $.ajax({
                    method: 'GET',
                    url: "{{route('coupon-calculation')}}",
                    success: function(data) {
                        if (data.status === 'success') {
                            $('#discount').text('{{$settings->currency_icon}}'+data.discount)
                            $('#cart_total').text('{{$settings->currency_icon}}'+data.cart_total)
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        })


    </script>
@endpush