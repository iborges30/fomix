<?php


namespace Source\Models\OpitionProduct;


use Source\Core\Model;


class OpitionProduct extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("options_product", ["id"], ["option_id"]);
    }
}
