<?php

date_default_timezone_set('Europe/Kyiv');

interface ILoger
{
    public function log(string $message): void;
}

trait DateTimeTrait
{
    public function getCurrentDateTime(): string
    {
        return date("F j, Y, g:i a");
    }
}

trait FileWriterTrait
{
    private string $filename = __DIR__ . "/log.txt";

    public function writeToFile(string $message): void
    {
        $date = $this->getCurrentDateTime();

        $line = $date . ": " . $message . PHP_EOL;

        $result = file_put_contents(
            $this->filename,
            $line,
            FILE_APPEND | LOCK_EX
        );

        if ($result === false) {
            throw new RuntimeException(
                "Could not write to the log file."
            );
        }
    }
}

class FileLoger implements ILoger
{
    use DateTimeTrait, FileWriterTrait;

    public function __construct(string $filename = __DIR__ . "/log.txt")
    {
        $this->filename = $filename;
    }

    public function log(string $message): void
    {
        $this->writeToFile($message);
    }
}

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {

    $message = trim($_POST["message"] ?? "");

    if ($message !== "") {

        try {
            $logger = new FileLoger();
            $logger->log($message);

            $success = "Message was successfully saved!";

        } catch (RuntimeException $e) {
            $error = $e->getMessage();
        }

    } else {
        $error = "Please enter a message.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Logger</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            box-sizing: border-box;
            resize: vertical;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>File Logger</h2>

        <form method="POST" action="">

            <label for="message">Enter your message:</label>

            <br><br>

            <textarea name="message" id="message" placeholder="Type your message here..." required></textarea>

            <br>

            <button type="submit">Save message</button>

        </form>

        <?php if (isset($success)): ?>
            <p class="success">
                <?= htmlspecialchars($success) ?>
            </p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p class="error">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

    </div>

</body>

</html>