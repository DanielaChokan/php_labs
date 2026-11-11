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

    public function show()
    {
        echo "Country: " . $this->country . "<br>";
        echo "Area: " . $this->area . " km²<br>";
        echo "Population: " . $this->population . "<br>";
        echo "Continent: " . $this->continent . "<br>";
        echo "--------------------<br>";
    }
}

class CityFactory
{
    public static function createCity($country, $area, $population, $continent)
    {
        $city = new City();
        $city->set($country, $area, $population);
        $city->setContinent($continent);
        return $city;
    }
}

echo "<h3>Завдання 6: Шаблон Factory для класу з ЛР №1</h3>";

$city1 = CityFactory::createCity("Ukraine", 839, 2950000, "Europe");
$city2 = CityFactory::createCity("France", 105, 2100000, "Europe");
$city3 = CityFactory::createCity("Japan", 2194, 14000000, "Asia");

$city1->show();
$city2->show();
$city3->show();
?>