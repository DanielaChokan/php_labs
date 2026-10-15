<?php

interface ILoger
{
    public function log(string $message): void;
}

class DbLoger implements ILoger
{
    private PDO $pdo;

    public function __construct(string $databaseFile)
    {
        $this->pdo = new PDO("sqlite:" . $databaseFile);

        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                log_date TEXT NOT NULL,
                message TEXT NOT NULL
            )"
        );
    }

    public function log(string $message): void
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO logs (log_date, message)
             VALUES (:log_date, :message)"
        );

        $statement->execute([
            "log_date" => date("Y-m-d H:i:s"),
            "message" => $message
        ]);
    }
}

$logger = new DbLoger(__DIR__ . "/logs.db");

$logger->log("First database log message");
$logger->log("Second database log message");

echo "Messages were saved to the database.";

?>