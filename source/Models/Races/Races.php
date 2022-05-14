<?php


namespace Source\Models\Races;


use Source\Core\Model;

class Races extends Model
{
    /**
     * Access constructor.
     */
    public function __construct()
    {
        parent::__construct("races", ["id"], []);
    }
}