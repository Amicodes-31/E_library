<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../../Config/db-connect.php';

// Process the update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_book'])) {

    $id = (int) $_POST['id'];
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $publisher = trim($_POST['publisher']);
    $quantity = (int) $_POST['quantity'];
    $category_id = (int) $_POST['category_id'];

    $sql = "UPDATE books
            SET category_id = ?, title = ?, author = ?,
                isbn = ?, publisher = ?, quantity = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "issssii",
        $category_id,
        $title,
        $author,
        $isbn,
        $publisher,
        $quantity,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../book.php");
        exit;
    } else {
        echo "Update failed: " . htmlspecialchars(mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}
?>