<?php

interface iTariff
{
    public function getPrice($km, $minutes);
}

abstract class Tariff implements iTariff
{
    use extraServices {
        getPrice as traitGetPrice;
    }

    protected $pricePerKm = 10;
    protected $pricePerMin = 3;
    protected $km;
    protected $minutes;
    protected $extraService = [];

    public function __construct(int $km, int $minutes)
    {
        $this->km = $km;
        $this->minutes = $minutes;
    }

    abstract protected function getDetailPrice($km, $minutes);

    final public function getPrice($km, $minutes): int
    {
        $price = $this->getDetailPrice($km, $minutes);
        return $price + $this->traitGetPrice($km, $minutes);
    }
}

class Basic extends Tariff
{
    protected function getDetailPrice($km, $minutes)
    {
        $price = $km * $this->pricePerKm + $minutes * $this->pricePerMin;
        return $price;
    }
}

class Hourly extends Tariff
{
    protected $pricePerKm = 0;
    protected $pricePerMin = 200 / 60;

    protected function getDetailPrice($km, $minutes)
    {
        if($minutes < 60) {
            $minutes = 60;
        } else {
            $rest = $minutes % 60;
            $minutes = $minutes = $rest + 60;
        }
        $price = $km * $this->pricePerKm + $minutes * $this->pricePerMin;
        return $price;
    }
}

class Student extends Tariff
{
    protected $pricePerKm = 4;
    protected $pricePerMin = 1;

    protected function getDetailPrice($km, $minutes)
    {
        $price = $km * $this->pricePerKm + $minutes * $this->pricePerMin;
        return $price;
    }
}

trait extraServices {
    protected $extraService = [];

    public function addExtraService(iTariff $tariff)
    {
        array_push($this->extraService, $tariff);
    }

    public function getPrice($km, $minutes)
    {
        $price = 0;

        foreach ($this->extraService as $extraService) {
            $price += $extraService->getPrice($km, $minutes);
        }
        return $price;
    }
}
class Gps implements iTariff
{
    private $pricePerHour = 15;

    public function getPrice($km, $minutes)
    {
        $hours = ceil($minutes / 60);
        return $price + $this->pricePerHour * $hours;
    }
}

class Driver implements iTariff
{
    private $priceForDriver = 100;

    public function getPrice($km, $minutes)
    {
        return $this->priceForDriver;
    }
}

$trip = new Hourly(1,1);

echo '<br>';
echo $trip->addExtraService(new Driver());
echo $trip->addExtraService(new Gps());
echo '<br>';
echo $trip->getPrice(1,40);

