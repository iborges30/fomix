<?php


namespace Source\Models\EnterprisesCoupons;


use Source\Core\Model;

class EnterprisesCoupons extends Model
{
    public function __construct()
    {
        parent::__construct("enterprises_coupons", ["id"], []);
    }
}