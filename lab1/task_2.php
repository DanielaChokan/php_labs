<?php

class Coor
{
    private $name;

    public function Getname()
    {
        return $this->name;
    }

    public function Setname($text)
    {
        $this->name = $text;
    }
}

$works = array();

$works[0] = new Coor();
$works[0]->Setname("Nick");

$works[1] = new Coor();
$works[1]->Setname("Nick 1");

$works[2] = new Coor();
$works[2]->Setname("Nick 2");

for ($i = 0; $i < 3; $i++) {
    echo $works[$i]->Getname() . "<br>";
}

?>