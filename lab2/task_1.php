<?php

class A
{
    public function example()
    {
        echo "This is parent function A::example().<br>";
    }
}

class B extends A
{
    public function example()
    {
        echo "This is overridden function B::example().<br>";
        parent::example();
    }
}

$b = new B();
$b->example();

?>