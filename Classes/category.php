<?php

class Category {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCategories() {

        $sql = "SELECT * FROM categories ORDER BY id DESC";

        return mysqli_query($this->conn, $sql);
    }

}