<?php

class WorkWithFile
{
    public $buff;
    public $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;

        if (!file_exists($this->filename)) {
            exit("File does not exist");
        }

        $fd = fopen($this->filename, "r");

        if (!$fd) {
            exit("File open error");
        }

        $this->buff = fread($fd, filesize($this->filename));

        fclose($fd);
    }

    public function getContent()
    {
        return $this->buff;
    }

    public function getSize()
    {
        return filesize($this->filename);
    }

    public function getCount()
    {
        if (!empty($this->filename)) {
            $arr = file($this->filename);

            return count($arr);
        }

        return 0;
    }
}

$first = new WorkWithFile("count.txt");

echo nl2br($first->getContent());
echo "<br>";

echo "File size: " . $first->getSize() . " bytes<br>";
echo "Number of lines: " . $first->getCount();

?>