<?php

class Coor
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function Getname()
    {
        echo "Name: " . $this->name . "<br>";
    }

    public function __destruct()
    {
        echo "Object " . $this->name . " is destroyed.<br>";
    }
}

$object = new Coor("Nick");

$object->Getname();

?>