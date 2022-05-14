<?php


namespace Source\Models\FlavorProduct;


use Source\Core\Model;


class FlavorProduct extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("flavor_product", ["id"], ["flavor_id"]);
    }
}