<?php


use Source\Models\CartItems\CartItems;

class CartRepository{

    public function save(){
        $cart = new CartItems();
        $cart->id_orders_items = '';
        $cart->category_items = '';
        $cart->amount = '';
        $cart->price = '';
        $cart->status = 1;
        $cart->save();
    }
}