<?php


namespace Source\Models\OrdersItems;


use Source\Core\Model;

class OrdersItems extends Model
{
    public function __construct()
    {
        parent::__construct("orders_items", ["id"], []);
    }
}