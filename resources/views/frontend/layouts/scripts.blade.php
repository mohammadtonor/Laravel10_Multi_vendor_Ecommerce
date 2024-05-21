<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add product into cart
        $('.shopping-cart-form').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                method: 'POST',
                data: formData,
                url: '{{route('add-to-cart')}}',
                success: function (data) {
                    if(data.status === 'success') {
                        getCartCount();
                        fetchSidebarCartProduct();
                        $('.mini_cart_actions').removeClass('d-none');
                        getSidebarCartSubtotal();
                        toastr.success(data.message);
                    } else if (data.status === 'error') {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    toastr.success(data.message);
                }
            })
        })

        function getCartCount(){
            $.ajax({
                method: 'GET',
                url: "{{route('cart-count')}}",
                success: function (data) {
                    $('.cart-count').text(data);
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }

        function fetchSidebarCartProduct() {
            $.ajax({
                method: 'GET',
                url: "{{route('cart-products')}}",
                success: function (data) {
                    $('.mini_cart_wrapper').html("");
                    let html = '';
                    for(item in data) {
                        let product = data[item];
                        html += `
                            <li id="mini-cart-${product.rowId}">
                                <div class="wsus__cart_img">
                                    <a href="{{url('product-detail')}}/${product.options.slug}">
                                        <img src="{{asset('/')}}${product.options.image}" alt="product" class="img-fluid w-100">
                                    </a>
                                    <a class="wsis__del_icon remove_sidebar_product" data-rowId=${product.rowId} href="#"><i class="fas fa-minus-circle"></i></a>
                                </div>
                                <div class="wsus__cart_text">
                                    <a class="wsus__cart_title" href="{{url('product-detail')}}/${product.options.slug}">${product.name}</a>
                                    <p>{{$settings->currency_icon}}${product.price}</p>
                                    <small>Variant Total: {{$settings->currency_icon}}${product.options.variants_total}</small>
                                    <br>
                                    <small>Qty: ${product.qty}</small>
                                </div>
                            </li>`;
                    }
                    $('.mini_cart_wrapper').html(html);
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }

        //Remove product from sidebar cart
        $('body').on('click', '.remove_sidebar_product', function (e) {
            e.preventDefault();
            let rowId = $(this).data('rowid');

            $.ajax({
                method: 'POST',
                data: {
                    rowId
                },
                url: "{{route('cart.remove-sidebar-product')}}",
                success: function (data) {
                    if(data.status == 'success') {
                        let productId = "#mini-cart-"+rowId;
                        $(productId).remove();
                        if ($('.mini_cart_wrapper').find('li').length === 0) {
                            $('.mini_cart_actions').addClass('d-none')
                            $('.mini_cart_wrapper').html('<li class="text-center">Cart is Empty</li>');
                        }
                        getSidebarCartSubtotal();
                        toastr.success(data.message)
                    } else {
                        tostr.error('Error Happened');
                    }
                },
                error: function(data) {
                }
            })
        })

        //get Subtotal cart
        function getSidebarCartSubtotal() {
            $.ajax({
                method: 'GET',
                url: "{{route('cart.sidebar-product-total')}}",
                success: function (data) {
                    $('.mini_cart_subtotal').text("{{$settings->currency_icon}}"+data)
                },
                error: function(data) {
                    console.log(data);
                }
            })
        }


    })
</script>
