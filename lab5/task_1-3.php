<?php
trait SingletonTrait
{
    protected static $_instance = null;

    protected function __construct()
    {
    }
    protected function __clone()
    {
    }
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

class SomeClass
{
    use SingletonTrait;
}

$objA = SomeClass::getInstance();
$objB = SomeClass::getInstance();
echo "Об'єкти SomeClass однакові: " . ($objA === $objB ? 'Так' : 'Ні') . "<br>";

class Database
{
    use SingletonTrait;

    public $db;

    protected function __construct()
    {
        echo "<h3>Connecting with database...</h3>";

        try {
            $this->db = @new \mysqli('localhost', 'root', '');

            if ($this->db !== null && !$this->db->connect_error) {
                $this->db->query("SET NAMES 'UTF8'");
            } else {
                echo "<p style='color:red; font-size:12px;'><i>(Попередження: MySQL не підключено, але Singleton продовжує роботу)</i></p>";
            }
        } catch (\Throwable $e) {
            echo "<p style='color:red; font-size:12px;'><i>(Помилка: " . $e->getMessage() . ")</i></p>";
        }
    }
}

$db1 = Database::getInstance();
$db2 = Database::getInstance();
$db3 = Database::getInstance();

echo "Об'єкти БД однакові: " . ($db1 === $db3 ? 'Так' : 'Ні') . "<br>";
?>