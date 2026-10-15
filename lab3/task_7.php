<?php

interface Int1
{
    public function func1(): void;
}

interface Int2
{
    public function func2(): void;
}

class MyClass implements Int1, Int2
{
    public function func1(): void
    {
        echo "1";
    }

    public function func2(): void
    {
        echo "2";
    }
}

$obj = new MyClass();

$obj->func1();
$obj->func2();

?>