<?php
class City
{
    public $country;
    public $area;
    public $population;

    public function set($country, $area, $population)
    {
        $this->country = $country;
        $this->area = $area;
        $this->population = $population;
    }
    public function get()
    {
        return ["country" => $this->country, "area" => $this->area, "population" => $this->population];
    }
}

interface IStringCityInfo
{
    public function getCityString(): string;
}

class CityStringAdapter implements IStringCityInfo
{
    private $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getCityString(): string
    {
        $data = $this->city->get();
        return "Країна: {$data['country']} | Площа: {$data['area']} км² | Населення: {$data['population']} осіб.";
    }
}

$myCity = new City();
$myCity->set("Japan", 2194, 14000000);

$cityAdapter = new CityStringAdapter($myCity);

echo "<h3>Адаптований вивід:</h3>";
echo $cityAdapter->getCityString();
?>