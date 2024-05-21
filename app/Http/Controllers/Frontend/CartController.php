<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\CartItemOptions;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    /** Show cart page */
    public function cartDetails() {
        $cartItems = Cart::content();

        if (count($cartItems) === 0 ) {
            Session::forget('coupon');
            toastr('Please add product to your cart to able this page', 'warning', 'Cart is Empty');
            return redirect()->route('home');
        }

        return view('frontend.pages.cart-detail', compact('cartItems'));
    }

    /** Add to Cart*/
    public function addToCart (Request $request) {
        $product = Product::findOrFail($request->product_id);

        //$qty = $request->qty == 1 ? $product->qty + 1 : $request->qty;
        if($product->qty === 0) {
            return response(['status' => 'error', 'message' => 'Product Stock out!']);
        } else if (($request->qty - $product->qty) > 0) {
            return response(['status' => 'error', 'message' => 'Quantity not available!']);
        }

        $variants = [];
        $vartiantTotalAmount = 0;
        if($request->has('variant_items')) {
            foreach($request->variant_items as $item_id) {
                $variantItem = ProductVariantItem::find($item_id);
                $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
                $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;
                $vartiantTotalAmount += $variantItem->price;
            }
        }

        /** check discoumt */
        $productPrice = 0;
        if (checkDiscount($product)) {
            $productPrice += $product->offer_price;
        } else {
            $productPrice += $product->price;
        }

        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['productQty'] = $product->qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $vartiantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;
        Cart::add($cartData);

        return response(['status' => 'success', 'message' => 'Added To Cart Successfully']);
    }

    /**Update Product quantity */
    public function updateProductQty (Request $request) {
        $productId = Cart::get($request->rowId)->id;
        $product = Product::findOrFail($productId);

        if($product->qty === 0) {
            return response(['status' => 'error', 'message' => 'Product Stock out!']);
        } else if ($product->qty < $request->quantity) {
            return response(['status' => 'error', 'message' => 'Quantity not available!']);
        }

        Cart::update($request->rowId, $request->quantity);
        $productTotal = $this->getProductTotal($request->rowId);
        return response(['status' => 'success', 'message' => 'Product Quantity Updated!', 'product_total' => $productTotal]);
    }

    public function getProductTotal($rowId) {
        $product = Cart::get($rowId);
        $total = ($product->price + $product->options->variants_total ) * $product->qty;
        return $total;
    }

    /** Clear all Cart proudcts */
    public function clearCart () {
        Cart::destroy();
        return response(['status' => 'success', 'message' => 'Cart Clear Successfully']);
    }

    /** Clear product  */
    public function removeProduct($rowId) {
        Cart::remove($rowId);
        return redirect()->back();
    }

    /** Get cart Count */
    public function getCartCount()
    {
        return Cart::content()->count();
    }

    /** Get all cart products */
    public function getCartProducts() {
        return Cart::content();
    }

    /** Remove sidebar product*/
    public function removeSidebarProduct(Request $request) {
        Cart::remove($request->rowId);

        return response(['status' => 'success', 'message' => 'Pruduct Removed Succcesfully!']);
    }

    public function getCartTotal () {
        $total = 0;

        foreach(Cart::content() as $product) {
            $total += $this->getProductTotal($product->rowId);
        }

        return $total;
    }

    /** Apply coupon */
    public function applyCoupon(Request $request) {
        if($request->coupon_code === null) {
            return response(['status' => 'error', 'message' => 'Coupon failed in request!']);
        }

        $coupon = Coupon::where(['code' => $request->coupon_code, 'status' => 1])->first();

        if($coupon === null) {
            return response(['status' => 'error', 'message' => 'Coupon not exist!']);
        } elseif ($coupon->start_date > date('Y-m-d')) {
            return response(['status' => 'error', 'message' => 'Coupon not started!']);
        } elseif($coupon->end_date < date('Y-m-d')) {
            return response(['status' => 'error', 'message' => 'Coupon is expired!']);
        } elseif($coupon->total_used > $coupon->quantity) {
            return response(['status' => 'error', 'message' => 'you can not applied this coupon!']);
        }
        if ($coupon->discount_type === 'amount') {
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'amount',
                'discount' => $coupon->discount
            ]);
        } elseif($coupon->discount_type === 'percent') {
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'percent',
                'discount' => $coupon->discount
            ]);
        }

        return response(['status' => 'success', 'message' => 'Coupon applied successfully!']);
    }

    public function couponCalculation () {
        if(Session::has('coupon')) {
            $coupon = Session::get('coupon');
            $subtotal = getCartTotal();
            if($coupon['discount_type'] === 'amount') {
                $total = $subtotal - $coupon['discount'];
                return response(['status' => 'success', 'cart_total' => $total, 'discount' => $coupon['discount']]);
            } elseif ($coupon['discount_type'] === 'percent') {
                $discount = ($subtotal * $coupon['discount'] / 100);
                $total = $subtotal - $discount;
                return response(['status' => 'success', 'cart_total' => $total, 'discount' => $discount]);
            }
        } else {
            $total = getCartTotal();
            return response(['status' => 'success', 'cart_total' => $total, 'discount' => 0]);
        }
    }
}
