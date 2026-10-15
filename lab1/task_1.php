<?php

class Coor
{
    private $name;

    public function Setname($text)
    {
        $this->name = $text;
    }

    public function Getname()
    {
        return $this->name;
    }
}

$object = new Coor();

$object->Setname("Nick");

echo $object->Getname();

?>
