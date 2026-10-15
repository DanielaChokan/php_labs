<?php

interface ILoger
{
    public function log(string $message): void;
}

class FileLoger implements ILoger
{
    private $file;

    public function __construct(string $filename, string $mode = "a")
    {
        $this->file = fopen($filename, $mode);

        if ($this->file === false) {
            throw new RuntimeException("Could not open the log file.");
        }
    }

    public function log(string $message): void
    {
        $date = date("F j, Y, g:i a");
        $line = $date . ": " . $message . PHP_EOL;

        if (fwrite($this->file, $line) === false) {
            throw new RuntimeException("Could not write to the log file.");
        }
    }

    public function __destruct()
    {
        if (is_resource($this->file)) {
            fclose($this->file);
        }
    }
}

$logger = new FileLoger(__DIR__ . "/log.txt");

$logger->log("log message");
$logger->log("another log message");

echo "Messages were written to log.txt.";

?>