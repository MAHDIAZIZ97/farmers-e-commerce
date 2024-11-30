<?php
  namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

  class CartManagement{

    public static function addItemToCart(int $product_id): int {
        $cart_items = self::getCartItemsFromCookie() ?? [];
        $existing_item_key = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item_key = $key;
                break;
            }
        }

        if ($existing_item_key !== null) {
            $cart_items[$existing_item_key]['quantity']++;
            $cart_items[$existing_item_key]['total_amount'] =
                $cart_items[$existing_item_key]['quantity'] * $cart_items[$existing_item_key]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->images[0] ?? null,
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }



    public static function removeCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();
        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                unset($cart_items[$key]);
                break;
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    public static function addCartItemsToCookie($cart_items){
        Cookie::queue('cart_items',json_encode($cart_items), 60*24*30);
    }

    public static function addItemToCartwithQty(int $product_id, $qty = 1): int {
        $cart_items = self::getCartItemsFromCookie() ?? [];
        $existing_item_key = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item_key = $key;
                break;
            }
        }

        if ($existing_item_key !== null) {
            $cart_items[$existing_item_key]['quantity']=$qty;
            $cart_items[$existing_item_key]['total_amount'] =
                $cart_items[$existing_item_key]['quantity'] * $cart_items[$existing_item_key]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->images[0] ?? null,
                    'quantity' => $qty,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }


    public static function clearCartItems(){
        Cookie::queue(Cookie::forget('cart_items'));
    }



    public static function getCartItemsFromCookie(){
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if(!$cart_items){
            $cart_items = [];
        }
        return $cart_items;
    }


    public static function incrementQuantityToCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();
        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] *
                   $cart_items[$key]['unit_amount'];
                break;
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    public static function decrementQuantityToCartItem($product_id){
        $cart_items = self::getCartItemsFromCookie();
        foreach($cart_items as $key => $item){
            if($item['product_id'] == $product_id){
                $cart_items[$key]['quantity']--;
                if($cart_items[$key]['quantity'] <= 0){
                    unset($cart_items[$key]);
                }
                else{
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] *
                       $cart_items[$key]['unit_amount'];
                }
                break;
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    public static function calculateGrandTotal($items){
        return array_sum(array_column($items, 'total_amount'));
    }
  }
