<?php

abstract class Coor
{
    private string $firstName = "";
    private string $lastName = "";

    public function setName(string $firstName, string $lastName): void
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getName(): string
    {
        return "$this->firstName $this->lastName";
    }

    abstract public function showWelcomeMessage(): void;
}

class Visitor extends Coor
{
    public function showWelcomeMessage(): void
    {
        echo "Hi " . $this->getName()
            . ", welcome to our shop! To buy something, please register!<br>";
    }

    public function newMessage(string $subject): void
    {
        echo "Creating new message: $subject<br>";
    }
}

class Shopper extends Coor
{
    public function showWelcomeMessage(): void
    {
        echo "Hi " . $this->getName()
            . ", welcome to our online store!<br>";
    }

    public function addToCart(string $item): void
    {
        echo "Adding $item to cart<br>";
    }
}

$visitor = new Visitor();
$visitor->setName("Anna", "Smith");
$visitor->showWelcomeMessage();
$visitor->newMessage("Registration");

echo "<hr>";

$shopper = new Shopper();
$shopper->setName("John", "Brown");
$shopper->showWelcomeMessage();
$shopper->addToCart("Perfume");

?>