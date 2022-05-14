<?php

namespace App;

interface DirectionInterface
{
    public function getDirection($origin, $destination, $mode);
}
