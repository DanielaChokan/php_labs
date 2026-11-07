<?php

date_default_timezone_set('Europe/Kyiv');

trait MyFirstTrait
{
    public function traitFunction(): void
    {
        echo "Hello world!\n";
    }

    public function greetingByTime(): void
    {
        $hour = (int) date("H");

        if ($hour >= 5 && $hour < 12) {
            $greeting = "Good morning!";
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Good day!";
        } elseif ($hour >= 18 && $hour < 22) {
            $greeting = "Good evening!";
        } else {
            $greeting = "Good night!";
        }

        echo $greeting . "\n";
    }
}

class HelloWorld
{
    use MyFirstTrait;
}

$objTest = new HelloWorld();

$objTest->traitFunction();
$objTest->greetingByTime();

?>