<?php

class Admin {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {

        $sql = "SELECT id, name, email, password
                FROM admin
                WHERE email = ?
                LIMIT 1";

        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result(
            $stmt,
            $id,
            $name,
            $adminEmail,
            $hashedPassword
        );

        if (
            mysqli_stmt_fetch($stmt) &&
            password_verify($password, $hashedPassword)
        ) {

            mysqli_stmt_close($stmt);

            return [
                'id' => $id,
                'name' => $name,
                'email' => $adminEmail
            ];
        }

        mysqli_stmt_close($stmt);

        return false;
    }

}