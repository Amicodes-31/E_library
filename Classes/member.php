<?php

class Member {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllMembers() {

        $sql = "SELECT * FROM members ORDER BY id DESC";

        return mysqli_query($this->conn, $sql);
    }

}