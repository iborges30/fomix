<?php


namespace Source\Models\Orders;


use Source\Core\Model;

class ItemsOrders extends Model
{
    public function __construct()
    {
        parent::__construct("items_orders", ["id"], ["order_id", "product_id", "price_item"]);
    }
}