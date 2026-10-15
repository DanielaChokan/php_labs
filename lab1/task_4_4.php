<?php

class Coor
{
    private $name;
    private $login;
    private $password;

    public function __construct($name, $login, $password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }

    public function Getname()
    {
        echo "Name: " . $this->name . "<br>";
        echo "Login: " . $this->login . "<br>";
        echo "Password: " . $this->password . "<br>";
    }
}

$object1 = new Coor("Nick", "nick01", "pass123");
$object2 = new Coor("John", "john02", "qwerty");
$object3 = new Coor("Anna", "anna03", "abc123");

$object1->Getname();
echo "<hr>";

$object2->Getname();
echo "<hr>";

$object3->Getname();

?>