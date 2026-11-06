<?php

class Borrowing {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBorrowings() {

        $sql = "SELECT
                    borrowings.id,
                    members.name AS member_name,
                    books.title AS book_title,
                    borrowings.borrow_date,
                    borrowings.due_date,
                    borrowings.return_date,
                    borrowings.status
                FROM borrowings
                INNER JOIN members
                    ON borrowings.member_id = members.id
                INNER JOIN books
                    ON borrowings.book_id = books.id
                ORDER BY borrowings.id DESC";

        return mysqli_query($this->conn, $sql);
    }

}