<?php

abstract class Figure
{
    protected float $centerX;
    protected float $centerY;

    public function __construct(float $centerX, float $centerY)
    {
        $this->centerX = $centerX;
        $this->centerY = $centerY;
    }

    abstract public function area(): float;

    public function showCenter(): void
    {
        echo "Center: (" . $this->centerX . ", "
            . $this->centerY . ")<br>";
    }
}

class Circle extends Figure
{
    private float $radius;

    public function __construct(
        float $centerX,
        float $centerY,
        float $radius
    ) {
        parent::__construct($centerX, $centerY);
        $this->radius = $radius;
    }

    public function area(): float
    {
        return pi() * $this->radius ** 2;
    }

    public function showInfo(): void
    {
        echo "<h3>Circle</h3>";
        $this->showCenter();
        echo "Radius: " . $this->radius . "<br>";
        echo "Area: " . round($this->area(), 2) . "<br>";
    }
}

class Rectangle extends Figure
{
    private float $width;
    private float $height;

    public function __construct(
        float $centerX,
        float $centerY,
        float $width,
        float $height
    ) {
        parent::__construct($centerX, $centerY);
        $this->width = $width;
        $this->height = $height;
    }

    public function area(): float
    {
        return $this->width * $this->height;
    }

    public function showInfo(): void
    {
        echo "<h3>Rectangle</h3>";
        $this->showCenter();
        echo "Width: " . $this->width . "<br>";
        echo "Height: " . $this->height . "<br>";
        echo "Area: " . $this->area() . "<br>";
    }
}

$circle = new Circle(2, 3, 5);
$rectangle = new Rectangle(4, 6, 8, 3);

$circle->showInfo();
$rectangle->showInfo();

?>