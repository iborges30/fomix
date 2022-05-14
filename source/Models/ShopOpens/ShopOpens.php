<?php


namespace Source\Models\ShopOpens;


use Source\Core\Model;


class ShopOpens extends Model
{
 
    public function __construct()
    {
        parent::__construct("shop_opens", ["id"], []);
    }
}
