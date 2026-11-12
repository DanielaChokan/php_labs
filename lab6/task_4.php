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
        echo "Country: {$this->country}, Continent: {$this->continent}, Population: {$this->population}<br>";
    }
}

echo "<h3>Демонстрація патерну Prototype для City</h3>";

$europeCityPrototype = new City();
$europeCityPrototype->setContinent("Europe");

$city1 = clone $europeCityPrototype;
$city1->set("Ukraine", 839, 2950000);

$city2 = clone $europeCityPrototype;
$city2->set("France", 105, 2100000);

$city1->show();
$city2->show();
?>