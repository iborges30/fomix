<?php


namespace Source\Models\FlavorItems;


use Source\Core\Model;


class FlavorItems extends Model
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct("flavor_items", ["id"], ["flavor_id"]);
    }
}
