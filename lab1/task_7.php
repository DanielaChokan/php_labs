<?php

class CSV
{
    private $_csv_file = null;

    public function __construct($csv_file)
    {
        if (file_exists($csv_file)) {
            $this->_csv_file = $csv_file;
        } else {
            throw new Exception("File not found");
        }
    }

    public function setCSV(array $csv)
    {
        $handle = fopen($this->_csv_file, "a");

        foreach ($csv as $value) {
            fputcsv($handle, explode(";", $value), ";");
        }

        fclose($handle);
    }

    public function getCSV()
    {
        $handle = fopen($this->_csv_file, "r");

        $array_line_full = [];

        while (($line = fgetcsv($handle, 0, ";")) !== false) {
            $array_line_full[] = $line;
        }

        fclose($handle);

        return $array_line_full;
    }
}

try {
    $csv = new CSV("file.csv");

    $get_csv = $csv->getCSV();

    foreach ($get_csv as $value) {
        echo "Country: " . $value[0] . "<br>";
        echo "Area: " . $value[1] . " km²<br>";
        echo "Population: " . $value[2] . "<br>";
        echo "--------------------<br>";
    }

    $arr = [
        "Germany;891;3800000"
    ];

    $csv->setCSV($arr);

    echo "New city was added.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>