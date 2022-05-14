<?php


namespace Source\Models\Orders;


use Source\Core\Model;

class Orders extends Model
{
    public function __construct()
    {
        parent::__construct("orders", ["id"], ["client", "document", "whatsapp"]);
    }

}