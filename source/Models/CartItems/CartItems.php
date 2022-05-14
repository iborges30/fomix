<?php

namespace Source\Models\CartItems;

use Source\Core\Model;

class CartItems extends Model
{
    public function __construct()
    {
        parent::__construct("orders_cart", ["id"], []);
    }

}