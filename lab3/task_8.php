<?php

interface IProduct
{
    public function showProductInfo(): void;
}

interface IFragrance
{
    public function showFragranceInfo(): void;
}

class Perfume implements IProduct, IFragrance
{
    private string $manufacturer;
    private string $manufactureDate;
    private int $concentration;
    private int $longevity;

    public function __construct(
        string $manufacturer,
        string $manufactureDate,
        int $concentration,
        int $longevity
    ) {
        $this->manufacturer = $manufacturer;
        $this->manufactureDate = $manufactureDate;
        $this->concentration = $concentration;
        $this->longevity = $longevity;
    }

    public function showProductInfo(): void
    {
        echo "Perfume information\n";
        echo "Manufacturer: {$this->manufacturer}\n";
        echo "Manufacture date: {$this->manufactureDate}\n";
        echo "Concentration: {$this->concentration}%\n";
    }

    public function showFragranceInfo(): void
    {
        echo "\nFragrance information\n";
        echo "Fragrance longevity: {$this->longevity} hours\n";
    }
}

$perfume = new Perfume("Chanel", "2026-05-10", 20, 8);

$perfume->showProductInfo();
$perfume->showFragranceInfo();

?>