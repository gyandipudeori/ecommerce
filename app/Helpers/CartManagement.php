<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement {
    // Add item  to cart
    static public function addItemToCart($product_id) {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;
    
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }
    
        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'image']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => isset($product->image) && is_array($product->images) ? $product->images[0] : null,
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }
    
        self::addCartItemsToCookie($cart_items);
        return [
            'cart_items' => $cart_items,
            'total_count' => count($cart_items), // Return total count explicitly
        ];
    }

     // Add item to cart with Qty
    static public function addItemToCartWithQty($product_id, $qty = 1) {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item = null;
    
        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }
    
        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity'] = $qty;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'image']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => isset($product->images) && is_array($product->images) ? $product->images[0] : null,
                    'quantity' => $qty,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }
    
        self::addCartItemsToCookie($cart_items);
        return [
            'cart_items' => $cart_items,
            'total_count' => count($cart_items), // Return total count explicitly
        ];
    }
    //remove item from cart
    static public function removeCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();

        foreach( $cart_items as $key => $item){
            if ($item['product_id'] == $product_id){
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    //add cart items to cookie
    static public function addCartItemsToCookie($cart_items){
        Cookie::queue('cart_items', json_encode($cart_items), 60*24*30);
    }
    //clear cart items from cookie
    static public function clearCartItems(){
        Cookie::queue(Cookie::forget('cart_items'));
    }
    //get all cart items from cookie
    static public function getCartItemsFromCookie(){
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if(!$cart_items){
            $cart_items =[];
        }
        return $cart_items;
    }
    //increment item quantity
    static public function incrementQuantityToCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount']= $cart_items[$key]['quantity']* $cart_items[$key]['unit_amount'];

            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    //decrement item quantity
    static public function decrementQuantityToCartItem($product_id){
        $cart_items= self::getCartItemsFromCookie();
        foreach ($cart_items as $key =>$item){
            if($item['product_id'] == $product_id){
                if($cart_items[$key]['quantity']>1){
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount']=$cart_items[$key]['quantity']* $cart_items[$key]['unit_amount'];
                }
            }
        }
        self::addCartItemsToCookie($cart_items);

        return $cart_items;
    }

    //calcute grand total
    static public function calculateGrandTotal($items){
        return array_sum(array_column($items, 'total_amount'));
    }
}
