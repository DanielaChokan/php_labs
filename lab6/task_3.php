<?php
abstract class AbstractCar
{
    abstract public function info();
}
abstract class AbstractTruck
{
    abstract public function info();
}
abstract class AbstractBus
{
    abstract public function info();
}

class UaCar extends AbstractCar
{
    public function info()
    {
        return "ЗАЗ Lanos";
    }
}
class UaTruck extends AbstractTruck
{
    public function info()
    {
        return "КрАЗ";
    }
}
class UaBus extends AbstractBus
{
    public function info()
    {
        return "Богдан";
    }
}

class ForeignCar extends AbstractCar
{
    public function info()
    {
        return "Toyota Camry";
    }
}
class ForeignTruck extends AbstractTruck
{
    public function info()
    {
        return "Volvo FH";
    }
}
class ForeignBus extends AbstractBus
{
    public function info()
    {
        return "Mercedes-Benz Sprinter";
    }
}

class FleetPrototypeFactory
{
    private $carPrototype;
    private $truckPrototype;
    private $busPrototype;

    public function __construct(AbstractCar $car, AbstractTruck $truck, AbstractBus $bus)
    {
        $this->carPrototype = $car;
        $this->truckPrototype = $truck;
        $this->busPrototype = $bus;
    }

    public function createCar(): AbstractCar
    {
        return clone $this->carPrototype;
    }
    public function createTruck(): AbstractTruck
    {
        return clone $this->truckPrototype;
    }
    public function createBus(): AbstractBus
    {
        return clone $this->busPrototype;
    }
}

$configString = "factory=ua carNum=10 truckNum=2 busNum=4";
parse_str(str_replace(' ', '&', $configString), $config);

if ($config['factory'] == 'ua') {
    $factory = new FleetPrototypeFactory(new UaCar(), new UaTruck(), new UaBus());
} else {
    $factory = new FleetPrototypeFactory(new ForeignCar(), new ForeignTruck(), new ForeignBus());
}

echo "<h3>Створення парку ({$config['factory']}) за допомогою Prototype</h3>";
echo "Легкових: " . $config['carNum'] . " шт. (Модель: " . $factory->createCar()->info() . ")<br>";
echo "Вантажних: " . $config['truckNum'] . " шт. (Модель: " . $factory->createTruck()->info() . ")<br>";
echo "Автобусів: " . $config['busNum'] . " шт. (Модель: " . $factory->createBus()->info() . ")<br>";
?>