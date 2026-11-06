<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../../Config/db-connect.php';

// Get book ID
if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    // Delete book
    $sql = "DELETE FROM books WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../book.php");
        exit;
    } else {
        echo "Unable to delete book: " .
             htmlspecialchars(mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}
?>