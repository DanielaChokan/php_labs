<?php

class FileComparator
{
    private $file1;
    private $file2;

    public function __construct($file1, $file2)
    {
        $this->file1 = $file1;
        $this->file2 = $file2;
    }

    public function compare()
    {
        if (!file_exists($this->file1) || !file_exists($this->file2)) {
            return "One or both files do not exist.";
        }

        $content1 = file_get_contents($this->file1);
        $content2 = file_get_contents($this->file2);

        if ($content1 === $content2) {
            return "Files are identical.";
        }

        return "Files are different.";
    }

    public function saveResult($resultFile)
    {
        $result = $this->compare();

        file_put_contents($resultFile, $result);

        return $result;
    }
}

$comparator = new FileComparator("file1.txt", "file2.txt");

$result = $comparator->saveResult("result.txt");

echo $result;

?>