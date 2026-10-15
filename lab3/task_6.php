<?php

interface Figure
{
    public function draw();
    public function erase();
    public function move();
    public function getColor();
    public function setColor($color);
}

class Circle implements Figure
{
    private $color;

    public function draw()
    {
        echo "Drawing Circle.\n";
    }

    public function erase()
    {
        echo "Erasing Circle.\n";
    }

    public function move()
    {
        echo "Moving Circle.\n";
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }
}

class Square implements Figure
{
    private $color;

    public function draw()
    {
        echo "Drawing Square.\n";
    }

    public function erase()
    {
        echo "Erasing Square.\n";
    }

    public function move()
    {
        echo "Moving Square.\n";
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }
}

class Triangle implements Figure
{
    private $color;

    public function draw()
    {
        echo "Drawing Triangle.\n";
    }

    public function erase()
    {
        echo "Erasing Triangle.\n";
    }

    public function move()
    {
        echo "Moving Triangle.\n";
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }
}

$circle = new Circle();
$circle->draw();
$circle->erase();

echo "\n";

$square = new Square();
$square->draw();
$square->erase();

echo "\n";

$triangle = new Triangle();
$triangle->draw();
$triangle->erase();

?>