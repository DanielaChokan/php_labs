<?php
interface CityProduct
{
    public function show();
}

class EuropeanCity implements CityProduct
{
    private $country, $area, $population;
    public function __construct($country, $area, $population)
    {
        $this->country = $country;
        $this->area = $area;
        $this->population = $population;
    }
    public function show()
    {
        return "Європейська країна: {$this->country} (Площа: {$this->area} km², Населення: {$this->population})";
    }
}

class AsianCity implements CityProduct
{
    private $country, $area, $population;
    public function __construct($country, $area, $population)
    {
        $this->country = $country;
        $this->area = $area;
        $this->population = $population;
    }
    public function show()
    {
        return "Азійська країна: {$this->country} (Площа: {$this->area} km², Населення: {$this->population})";
    }
}

interface CityFactory
{
    public function createCity($country, $area, $population): CityProduct;
}

class EuropeanCityFactory implements CityFactory
{
    public function createCity($country, $area, $population): CityProduct
    {
        return new EuropeanCity($country, $area, $population);
    }
}

class AsianCityFactory implements CityFactory
{
    public function createCity($country, $area, $population): CityProduct
    {
        return new AsianCity($country, $area, $population);
    }
}

echo "<h3>Завдання 10: Factory Method (Предметна область: City)</h3>";

$euFactory = new EuropeanCityFactory();
$city1 = $euFactory->createCity("Ukraine", 839, 2950000);
echo $city1->show() . "<br>";

$asiaFactory = new AsianCityFactory();
$city2 = $asiaFactory->createCity("Japan", 2194, 14000000);
echo $city2->show() . "<br>";
?>