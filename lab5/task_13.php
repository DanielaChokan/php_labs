<?php
trait LocationTrait {
    public function getContinentInfo() {
        return " | Континент: " . static::CONTINENT;
    }
}

interface Capital { public function getDetails(); }
interface RegionalCity { public function getDetails(); }

class EuropeanCapital implements Capital {
    use LocationTrait;
    const CONTINENT = 'Europe';
    public function getDetails() { return "Київ (Україна)" . $this->getContinentInfo(); }
}

class EuropeanRegional implements RegionalCity {
    use LocationTrait;
    const CONTINENT = 'Europe';
    public function getDetails() { return "Суми (Україна)" . $this->getContinentInfo(); }
}

class AsianCapital implements Capital {
    use LocationTrait;
    const CONTINENT = 'Asia';
    public function getDetails() { return "Токіо (Японія)" . $this->getContinentInfo(); }
}

class AsianRegional implements RegionalCity {
    use LocationTrait;
    const CONTINENT = 'Asia';
    public function getDetails() { return "Осака (Японія)" . $this->getContinentInfo(); }
}

interface AbstractRegionFactory {
    public function createCapital(): Capital;
    public function createRegionalCity(): RegionalCity;
}

class EuropeanRegionFactory implements AbstractRegionFactory {
    public function createCapital(): Capital { return new EuropeanCapital(); }
    public function createRegionalCity(): RegionalCity { return new EuropeanRegional(); }
}

class AsianRegionFactory implements AbstractRegionFactory {
    public function createCapital(): Capital { return new AsianCapital(); }
    public function createRegionalCity(): RegionalCity { return new AsianRegional(); }
}

echo "<h3>Завдання 13: Abstract Factory + Traits (Предметна область: City)</h3>";

$regionConfig = 'europe'; 

$factory = ($regionConfig === 'europe') ? new EuropeanRegionFactory() : new AsianRegionFactory();

echo "<b>Створення міст для регіону: " . strtoupper($regionConfig) . "</b><br>";
echo "Столиця: " . $factory->createCapital()->getDetails() . "<br>";
echo "Регіональне місто: " . $factory->createRegionalCity()->getDetails() . "<br>";
?>