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
}

$object = new Coor("Nick");

$object->Getname();

?>