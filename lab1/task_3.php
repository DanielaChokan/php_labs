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

    public function get()
    {
        return [
            "country" => $this->country,
            "area" => $this->area,
            "population" => $this->population
        ];
    }

    public function show()
    {
        echo "Country: " . $this->country . "<br>";
        echo "Area: " . $this->area . " km²<br>";
        echo "Population: " . $this->population . "<br>";
        echo "Population in millions: " .
            $this->getPopulationInMillions() . "<br>";
        echo "Continent: " . $this->continent . "<br>";
    }

    public function search($country)
    {
        return $this->country === $country;
    }

    private function getPopulationInMillions()
    {
        return round($this->population / 1000000, 2);
    }

    public function setContinent($continent)
    {
        $this->continent = $continent;
    }

    public function getContinent()
    {
        return $this->continent;
    }

    public static function show_objects($cities)
    {
        foreach ($cities as $city) {
            $city->show();
            echo "--------------------<br>";
        }
    }
}

// Creating 3 objects
$city1 = new City();
$city1->set("Ukraine", 839, 2950000);
$city1->setContinent("Europe");

$city2 = new City();
$city2->set("France", 105, 2100000);
$city2->setContinent("Europe");

$city3 = new City();
$city3->set("Japan", 2194, 14000000);
$city3->setContinent("Asia");

// Displaying 3 objects
echo "<h3>Three city objects</h3>";

$city1->show();
echo "<br>";

$city2->show();
echo "<br>";

$city3->show();
echo "<br>";

// Search
echo "<h3>Search</h3>";

if ($city1->search("Ukraine")) {
    echo "City belongs to Ukraine.<br>";
} else {
    echo "City does not belong to Ukraine.<br>";
}

// Array of 5 objects
$cities = [];

$city4 = new City();
$city4->set("Germany", 891, 3800000);
$city4->setContinent("Europe");

$city5 = new City();
$city5->set("USA", 1214, 830000);
$city5->setContinent("North America");

$cities[] = $city1;
$cities[] = $city2;
$cities[] = $city3;
$cities[] = $city4;
$cities[] = $city5;

echo "<h3>Array of five cities</h3>";

City::show_objects($cities);

?>