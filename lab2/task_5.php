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

        echo "Cosmetic constructor called." . PHP_EOL;
    }

    public function printInfo(): void
    {
        echo "--- Cosmetic product ---" . PHP_EOL;
        echo "Manufacturer: " . $this->manufacturer . PHP_EOL;
        echo "Manufacture date: " . $this->manufactureDate . PHP_EOL;
    }

    public function __destruct()
    {
        echo "Cosmetic destructor called." . PHP_EOL;
    }
}

class Perfume extends Cosmetic
{
    public static int $perfumeCount = 0;
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

        self::$perfumeCount++;

        echo "Perfume constructor called." . PHP_EOL;
    }

    public function printInfo(): void
    {
        echo "--- Perfume product ---" . PHP_EOL;
        echo "Manufacturer: " . $this->manufacturer . PHP_EOL;
        echo "Manufacture date: " . $this->manufactureDate . PHP_EOL;
        echo "Concentration: " . $this->concentration . "%" . PHP_EOL;
        echo "Fragrance longevity: " . $this->longevity . " hours" . PHP_EOL;
    }

    public static function getPerfumeCount(): int
    {
        return self::$perfumeCount;
    }

    public function __destruct()
    {
        echo "Perfume destructor called." . PHP_EOL;
        parent::__destruct();
    }
}

$perfume1 = new Perfume(
    "Chanel",
    "2026-05-10",
    20.0,
    8.0
);

$perfume2 = new Perfume(
    "Dior",
    "2026-06-15",
    15.0,
    6.0
);

$perfume3 = new Perfume(
    "Armani",
    "2026-07-20",
    18.0,
    10.0
);

$perfume1->printInfo();

echo "<h3>Static members</h3>";

echo "Number of perfume objects: "
    . Perfume::getPerfumeCount() . "<br>";

echo "Static property value: "
    . Perfume::$perfumeCount . "<br>";

?>