<?php


namespace Source\Models\Evaluation;


use Source\Core\Model;

class Evaluation extends Model
{

    public function __construct()
    {
        parent::__construct("evaluation", ["id"], ["evaluation"]);
    }


}