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

// Вітчизняні продукти
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

interface VehicleAbstractFactory
{
    public function createCar(): AbstractCar;
    public function createTruck(): AbstractTruck;
    public function createBus(): AbstractBus;
}

class DomesticFactory implements VehicleAbstractFactory
{
    public function createCar(): AbstractCar
    {
        return new UaCar();
    }
    public function createTruck(): AbstractTruck
    {
        return new UaTruck();
    }
    public function createBus(): AbstractBus
    {
        return new UaBus();
    }
}

class ForeignFactory implements VehicleAbstractFactory
{
    public function createCar(): AbstractCar
    {
        return new ForeignCar();
    }
    public function createTruck(): AbstractTruck
    {
        return new ForeignTruck();
    }
    public function createBus(): AbstractBus
    {
        return new ForeignBus();
    }
}

$configString = "factory=ua carNum=10 truckNum=2 busNum=4";
parse_str(str_replace(' ', '&', $configString), $config);

$factory = ($config['factory'] == 'ua') ? new DomesticFactory() : new ForeignFactory();

echo "<h3>Створення парку ({$config['factory']})</h3>";
echo "Легкових: " . $config['carNum'] . " шт. (Модель: " . $factory->createCar()->info() . ")<br>";
echo "Вантажних: " . $config['truckNum'] . " шт. (Модель: " . $factory->createTruck()->info() . ")<br>";
echo "Автобусів: " . $config['busNum'] . " шт. (Модель: " . $factory->createBus()->info() . ")<br>";
?>