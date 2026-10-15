<?php

class CityCSV
{
    private $filename;

    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new Exception("File not found");
        }

        $this->filename = $filename;
    }

    public function getCities()
    {
        $handle = fopen($this->filename, "r");

        $cities = [];

        while (($row = fgetcsv($handle, 0, ";")) !== false) {
            $cities[] = [
                "country" => $row[0],
                "area" => $row[1],
                "population" => $row[2]
            ];
        }

        fclose($handle);

        return $cities;
    }

    public function showCities()
    {
        $cities = $this->getCities();

        foreach ($cities as $city) {
            echo "Country: " . $city["country"] . "<br>";
            echo "Area: " . $city["area"] . " km²<br>";
            echo "Population: " . $city["population"] . "<br>";
            echo "--------------------<br>";
        }
    }
}

try {
    $cities = new CityCSV("cities.csv");

    $cities->showCities();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>