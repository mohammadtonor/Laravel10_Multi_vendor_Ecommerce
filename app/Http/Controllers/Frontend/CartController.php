<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\CartItemOptions;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /** Add to Cart*/
    public function addToCart (Request $request) {
        $product = Product::findOrFail($request->product_id);

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
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $vartiantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;
        Cart::add($cartData);

        return response(['status' => 'success', 'message' => 'Added To Cart Successfully']);
    }

    /** Show cart page */
    public function cartDetails() {
        $cartItems = Cart::content();
        return view('frontend.pages.cart-detail', compact('cartItems'));
    }

    /**Update Product quantity */
    public function updateProductQty (Request $request) {
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
}
