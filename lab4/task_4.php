<?php

trait AreaTrait
{
    protected float $area;

    public function setArea(float $area): void
    {
        $this->area = $area;
    }

    public function getArea(): float
    {
        return $this->area;
    }

    public function showArea(): void
    {
        echo "Area: " . $this->area . " km²<br>";
    }
}

trait PopulationTrait
{
    protected int $population;

    public function setPopulation(int $population): void
    {
        $this->population = $population;
    }

    public function getPopulation(): int
    {
        return $this->population;
    }

    public function showPopulation(): void
    {
        echo "Population: " . $this->population . "<br>";
    }
}

trait GovernmentTrait
{
    private string $government;

    public function setGovernment(string $government): void
    {
        $this->government = $government;
    }

    public function showGovernment(): void
    {
        echo "Government location: "
            . $this->government . "<br>";
    }
}

abstract class Place
{
    protected string $name;
    protected string $country;

    public function __construct(
        string $name,
        string $country
    ) {
        $this->name = $name;
        $this->country = $country;
    }

    abstract public function showInfo(): void;
}

class City extends Place
{
    use AreaTrait, PopulationTrait;

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

        $this->showArea();
        $this->showPopulation();
    }
}

class Capital extends City
{
    use GovernmentTrait;

    public function __construct(
        string $name,
        string $country,
        float $area,
        int $population,
        string $government
    ) {
        parent::__construct(
            $name,
            $country,
            $area,
            $population
        );

        $this->government = $government;
    }

    public function showInfo(): void
    {
        echo "<h3>Capital city</h3>";

        echo "Name: " . $this->name . "<br>";
        echo "Country: " . $this->country . "<br>";

        $this->showArea();
        $this->showPopulation();
        $this->showGovernment();
    }
}

$city = new City(
    "Lviv",
    "Ukraine",
    149.0,
    717000
);

$capital = new Capital(
    "Kyiv",
    "Ukraine",
    839.0,
    2950000,
    "Parliament and government"
);

$city->showInfo();

echo "<hr>";

$capital->showInfo();

?>