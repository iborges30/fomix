<?php


namespace Source\Models\AdditionalItems;


use Source\Core\Model;


class AdditionalItems extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("additional_items", ["id"], ["additional_id"]);
    }
}
