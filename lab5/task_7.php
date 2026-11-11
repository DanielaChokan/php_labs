<?php
class Vehicle
{
    protected $country, $brand, $year;
    public function __construct($country, $brand, $year)
    {
        $this->country = $country;
        $this->brand = $brand;
        $this->year = $year;
    }
    public function getInfo()
    {
        return "$this->brand ($this->country, $this->year)";
    }
}

class Car extends Vehicle
{
    private $engine, $power, $color;
    public function __construct($c, $b, $y, $engine, $power, $color)
    {
        parent::__construct($c, $b, $y);
        $this->engine = $engine;
        $this->power = $power;
        $this->color = $color;
    }
    public function getDetails()
    {
        return parent::getInfo() . " - Car [Двигун: $this->engine, Потужність: $this->power, Колір: $this->color]<br>";
    }
}

class Bike extends Vehicle
{
    private $weight, $type, $wheelDiameter;
    public function __construct($c, $b, $y, $weight, $type, $wheelDiameter)
    {
        parent::__construct($c, $b, $y);
        $this->weight = $weight;
        $this->type = $type;
        $this->wheelDiameter = $wheelDiameter;
    }
    public function getDetails()
    {
        return parent::getInfo() . " - Bike [Вага: $this->weight, Тип: $this->type, Колеса: $this->wheelDiameter]<br>";
    }
}

class Motorcycle extends Vehicle
{
    private $engine, $color, $type;
    public function __construct($c, $b, $y, $engine, $color, $type)
    {
        parent::__construct($c, $b, $y);
        $this->engine = $engine;
        $this->color = $color;
        $this->type = $type;
    }
    public function getDetails()
    {
        return parent::getInfo() . " - Motorcycle [Двигун: $this->engine, Колір: $this->color, Тип: $this->type]<br>";
    }
}

class VehicleFactory
{
    public static function create($type, $params)
    {
        switch (strtolower($type)) {
            case 'car':
                return new Car($params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);
            case 'bike':
                return new Bike($params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);
            case 'motorcycle':
                return new Motorcycle($params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);
            default:
                throw new Exception("Фабрика не може створити даний транспортний засіб: $type<br>");
        }
    }
}

try {
    $car = VehicleFactory::create('car', ['Німеччина', 'BMW', 2022, '3.0L', '340 к.с.', 'Чорний']);
    echo $car->getDetails();

    $bike = VehicleFactory::create('bike', ['Тайвань', 'Giant', 2023, '12 кг', 'Гірський', '29"']);
    echo $bike->getDetails();

    $boat = VehicleFactory::create('boat', []);
} catch (Exception $e) {
    echo "<b>Помилка:</b> " . $e->getMessage();
}
?>