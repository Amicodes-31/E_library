<?php

class Book {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBooks() {

        $sql = "SELECT * FROM books ORDER BY id DESC";

        return mysqli_query($this->conn, $sql);
    }

}