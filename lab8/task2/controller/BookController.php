<?php

require_once __DIR__ . '/../model/Book.php';

class BookController
{
    private $model;

    public function __construct()
    {
        $this->model = new Book();
    }

    public function invoke()
    {
        if (isset($_GET['id'])) {

            $id = filter_input(
                INPUT_GET,
                'id',
                FILTER_VALIDATE_INT
            );

            if ($id === false || $id === null || $id <= 0) {
                http_response_code(400);
                exit('Invalid book ID.');
            }

            $book = $this->model->getBook($id);

            if ($book) {
                require __DIR__ . '/../view/viewbook.php';
            } else {
                http_response_code(404);
                echo "Book not found.";
            }

        } else {

            $search = trim($_GET['search'] ?? '');

            $books = $this->model->getBookList($search);

            require __DIR__ . '/../view/booklist.php';
        }
    }
}

?>