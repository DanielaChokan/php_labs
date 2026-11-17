<?php

require_once __DIR__ . '/../config/Database.php';

class Book
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getBookList($search = '')
    {
        $sql = "
            SELECT
                books.id,
                books.title,
                books.description,
                books.publication_year,
                books.pages,
                books.cover_path,
                authors.first_name,
                authors.last_name,
                authors.country
            FROM books
            INNER JOIN authors
                ON books.author_id = authors.id
        ";

        if ($search !== '') {
            $sql .= "
                WHERE books.title LIKE :title
                OR authors.first_name LIKE :first_name
                OR authors.last_name LIKE :last_name
            ";
        }

        $sql .= " ORDER BY books.title ASC";

        $stmt = $this->db->prepare($sql);

        if ($search !== '') {
            $searchValue = '%' . $search . '%';

            $stmt->bindValue(':title', $searchValue);
            $stmt->bindValue(':first_name', $searchValue);
            $stmt->bindValue(':last_name', $searchValue);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getBook($id)
    {
        $sql = "
            SELECT
                books.id,
                books.title,
                books.description,
                books.publication_year,
                books.pages,
                books.cover_path,
                authors.first_name,
                authors.last_name,
                authors.country
            FROM books
            INNER JOIN authors
                ON books.author_id = authors.id
            WHERE books.id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}

?>