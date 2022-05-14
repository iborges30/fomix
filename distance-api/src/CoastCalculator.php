<?php

namespace App;

class CoastCalculator implements CoastCalculatorInterface
{
    private $minCoast;
    private $coastPerKm;
    private $km;

    /**
     * Set the value of km
     *
     * @return  self
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Set the value of minCoast
     *
     * @return  self
     */
    public function setMinCoast($minCoast)
    {
        $this->minCoast = $minCoast;

        return $this;
    }

    /**
     * Set the value of coastPerKm
     *
     * @return  self
     */
    public function setCoastPerKm($coastPerKm)
    {
        $this->coastPerKm = $coastPerKm;

        return $this;
    }

    public function calculate()
    {
        $totalCoast = $this->km * $this->coastPerKm;
        if($totalCoast < $this->minCoast)
        {
            $totalCoast = $this->minCoast;
        }
        return $totalCoast;
    }
}
