<?php

// set Sidebar item active

use Gloudemans\Shoppingcart\Facades\Cart;

function setActive (array $route) {
    if (is_array($route)) {
        foreach($route as $r) {
            if (request()->routeIs($r)) {
                return 'active';
            }
        }
    }
}

function checkDiscount($product) {
    $currentDate = date('Y-m-d');

    if($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date) {
        return true;
    }
    return false;
}

/** Claculate Discount Percentage */
function calculateDiscount ($product) {
    $discountAmont = $product->price - $product->offer_price;
    return ($discountAmont / $product->price) * 100;
}

/**
 * check Product Type
 */
function checkProductType (string $type) {
    switch($type) {
        case 'new_arrival':
            return 'New';
            break;
        case 'featured_product':
            return 'Featured';
            break;
        case 'top_product':
            return 'Top';
            break;
        case 'best_product':
            return 'Best';
            break;
        default:
            return '';
            break;
    }
}

function getCartSidebarTotal() {
    $total = 0;
    foreach(Cart::content() as $product) {
        $total += ($product->price + $product->options->variants_total ) * $product->qty;
    }

    return $total;
}
