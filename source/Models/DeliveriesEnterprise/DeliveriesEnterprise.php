<?php


namespace Source\Models\DeliveriesEnterprise;


use Source\Core\Model;

class DeliveriesEnterprise extends Model
{
    public function __construct()
    {
        parent::__construct("deliveries_enterprise", ["id"], ["race_origin",
            "arrival",
            "race_price",
            "vehicle",
            "type_box",
            "back"
        ]);
    }
}