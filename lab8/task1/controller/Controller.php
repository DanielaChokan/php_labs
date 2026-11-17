<?php

require_once __DIR__ . '/../model/Model.php';

class Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function invoke()
    {
        if (!isset($_GET['book'])) {

            $books = $this->model->getBookList();

            require __DIR__ . '/../view/booklist.php';

        } else {

            $title = $_GET['book'];

            $book = $this->model->getBook($title);

            if ($book !== null) {
                require __DIR__ . '/../view/viewbook.php';
            } else {
                http_response_code(404);
                echo "Book not found.";
            }
        }
    }
}

?>