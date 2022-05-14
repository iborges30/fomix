<?php


namespace Source\Models\OptionalItems;


use Source\Core\Model;


class OptionalItems extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("optional_items", ["id"], ["item_id"]);
    }
}
