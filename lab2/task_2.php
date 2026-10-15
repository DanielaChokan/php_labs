<?php

class Cosmetic
{
    protected string $manufacturer;
    protected string $manufactureDate;

    public function __construct(
        string $manufacturer,
        string $manufactureDate
    ) {
        $this->manufacturer = $manufacturer;
        $this->manufactureDate = $manufactureDate;

        echo "Cosmetic constructor called.<br>";
    }

    public function printInfo(): void
    {
        echo "<h3>Cosmetic product</h3>";
        echo "Manufacturer: " . $this->manufacturer . "<br>";
        echo "Manufacture date: " . $this->manufactureDate . "<br>";
    }

    public function __destruct()
    {
        echo "Cosmetic destructor called.<br>";
    }
}

class Perfume extends Cosmetic
{
    private float $concentration;
    private float $longevity;

    public function __construct(
        string $manufacturer,
        string $manufactureDate,
        float $concentration,
        float $longevity
    ) {
        parent::__construct($manufacturer, $manufactureDate);

        $this->concentration = $concentration;
        $this->longevity = $longevity;

        echo "Perfume constructor called.<br>";
    }

    public function printInfo(): void
    {
        echo "<h3>--- Perfume product ---</h3>";

        echo "Manufacturer: " . $this->manufacturer . "<br>";
        echo "Manufacture date: " . $this->manufactureDate . "<br>";
        echo "Concentration: " . $this->concentration . "%<br>";
        echo "Fragrance longevity: " . $this->longevity . " hours<br>";
    }

    public function __destruct()
    {
        echo "Perfume destructor called.<br>";
        parent::__destruct();
    }
}

$perfume = new Perfume(
    "Chanel",
    "2026-05-10",
    20.0,
    8.0
);

$perfume->printInfo();

?>