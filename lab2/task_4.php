<?php

class A
{
    public static function test(): void
    {
        echo "1";
    }

    public static function get(): void
    {
        static::test();
    }
}

class B extends A
{
    public static function test(): void
    {
        echo "2";
    }
}

B::get();

?>