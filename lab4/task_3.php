<?php

trait A
{
    public function a(): void
    {
        echo "Hello ";
    }
}

trait B
{
    public function b(): void
    {
        echo "world";
    }
}

class Test
{
    use A, B;

    public function c(): void
    {
        echo "!";
    }
}

$t = new Test();

$t->a();
$t->b();
$t->c();

?>