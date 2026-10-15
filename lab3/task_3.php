<?php

abstract class Place
{
    protected string $name;
    protected string $country;

    public function __construct(string $name, string $country)
    {
        $this->name = $name;
        $this->country = $country;
    }

    abstract public function showInfo(): void;
}

class City extends Place
{
    protected float $area;
    protected int $population;

    public function __construct(
        string $name,
        string $country,
        float $area,
        int $population
    ) {
        parent::__construct($name, $country);
        $this->area = $area;
        $this->population = $population;
    }

    public function showInfo(): void
    {
        echo "<h3>City</h3>";
        echo "Name: " . $this->name . "<br>";
        echo "Country: " . $this->country . "<br>";
        echo "Area: " . $this->area . " km²<br>";
        echo "Population: " . $this->population . "<br>";
    }
}

class Capital extends City
{
    private string $government;

    public function __construct(
        string $name,
        string $country,
        float $area,
        int $population,
        string $government
    ) {
        parent::__construct($name, $country, $area, $population);
        $this->government = $government;
    }

    public function showInfo(): void
    {
        echo "<h3>Capital city</h3>";
        echo "Name: " . $this->name . "<br>";
        echo "Country: " . $this->country . "<br>";
        echo "Area: " . $this->area . " km²<br>";
        echo "Population: " . $this->population . "<br>";
        echo "Government location: " . $this->government . "<br>";
    }
}

$city = new City("Lviv", "Ukraine", 149.0, 717000);
$capital = new Capital(
    "Kyiv",
    "Ukraine",
    839.0,
    2950000,
    "Parliament and government"
);

$city->showInfo();
$capital->showInfo();

?>