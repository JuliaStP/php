<?php
///???? how to add traits to price
trait Gps
{
    private $pricePerHour;

    public function addGps(Tariff $trip, &$price)
    {
        $hours = ceil($trip->getTime() / 60);
        $price += $this->pricePerHour * $hours;
    }
}

trait Driver
{
    private $price;

    public function addDriver(Tariff $trip, &$price)
    {
        $price += $this->price;
    }
}


interface iTariff
{
    public function getPrice(): int;
    public function addServiceGps(addGps $extraService): self;
    public function addServiceDriver(addDriver $extraService): self;
    public function getTime(): int;
    public function getKm(): int;
}

abstract class Tariff implements iTariff
{
    use Gps;
    use Driver;

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

    public function getPrice(): int
    {

        $price = $this->km * $this->pricePerKm + $this->minutes * $this->pricePerMin;

        if ($this->extraService) {
            foreach ($this->extraService as $service) {
                $service->apply($this, $price);
            }
        }

        return $price;
    }


    public function addServiceGps(addGps $extraService): iTariff
    {
        array_push($this->extraService, $extraService);
        return $this;
    }

    public function addServiceDriver(addDriver $extraService): iTariff
    {
        array_push($this->extraService, $extraService);
        return $this;
    }

    public function getTime(): int
    {
        return $this->minutes;
    }

    public function getKm(): int
    {
        return $this->km;
    }
}

class Basic extends Tariff
{

}

class Hourly extends Tariff
{
    protected $pricePerKm = 0;
    protected $pricePerMin = 200 / 60;

    public function __construct(int $km, int $minutes)
    {
        parent:: __construct($km, $minutes);

        if($this->minutes < 60) {
            $this->minutes = 60;
        } else {
            $rest = $this->minutes % 60;
            $this->minutes = $this->minutes = $rest + 60;
        }
    }
}

class Student extends Tariff
{
    protected $pricePerKm = 4;
    protected $pricePerMin = 1;
}

$trip = new Basic(5, 15);
echo '<br>';
echo $trip->getPrice();
echo '<br>';
