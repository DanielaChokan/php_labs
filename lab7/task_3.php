<?php
class City
{
    public $country;
    public $area;
    public $population;
    private $continent;

    public function set($country, $area, $population)
    {
        $this->country = $country;
        $this->area = $area;
        $this->population = $population;
    }
    public function setContinent($continent)
    {
        $this->continent = $continent;
    }
    public function getContinent()
    {
        return $this->continent;
    }
    public function show()
    {
        echo "Country: " . $this->country . " | Area: " . $this->area . " | Continent: " . $this->continent . "<br>";
    }
}

abstract class CityValidator
{
    protected $nextValidator;

    public function setNext(CityValidator $validator)
    {
        $this->nextValidator = $validator;
        return $validator;
    }

    abstract public function check(City $city);
}

class ContinentValidator extends CityValidator
{
    private $requiredContinent;

    public function __construct($continent)
    {
        $this->requiredContinent = $continent;
    }

    public function check(City $city)
    {
        if ($city->getContinent() !== $this->requiredContinent) {
            echo "Місто {$city->country} відхилено: не знаходиться в {$this->requiredContinent}.<br>";
            return false;
        }

        if ($this->nextValidator) {
            return $this->nextValidator->check($city);
        }
        return true;
    }
}

class AreaValidator extends CityValidator
{
    private $minArea;

    public function __construct($minArea)
    {
        $this->minArea = $minArea;
    }

    public function check(City $city)
    {
        if ($city->area < $this->minArea) {
            echo "Місто {$city->country} відхилено: площа {$city->area} менша за мінімальну {$this->minArea}.<br>";
            return false;
        }

        if ($this->nextValidator) {
            return $this->nextValidator->check($city);
        }
        return true;
    }
}

$city1 = new City();
$city1->set("Ukraine", 839, 2950000);
$city1->setContinent("Europe");

$city2 = new City();
$city2->set("Japan", 2194, 14000000);
$city2->setContinent("Asia");

$continentCheck = new ContinentValidator("Europe");
$areaCheck = new AreaValidator(500);

$continentCheck->setNext($areaCheck);

echo "<b>Перевірка міста Ukraine:</b><br>";
if ($continentCheck->check($city1)) {
    echo "<b>Успіх:</b> Місто {$city1->country} пройшло всі перевірки!<br>";
}

echo "<br><b>Перевірка міста Japan:</b><br>";
if ($continentCheck->check($city2)) {
    echo "<b>Успіх:</b> Місто {$city2->country} пройшло всі перевірки!<br>";
}
?>