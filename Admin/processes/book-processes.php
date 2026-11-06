<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../../Config/db-connect.php';

// Check if form was submitted
if (isset($_POST['add_book'])) {

    // Collect form details
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    $publisher = trim($_POST['publisher']);
    $quantity = (int) $_POST['quantity'];
    $category_id = (int) $_POST['category_id'];

    // Prepare SQL statement
    $sql = "INSERT INTO books
            (category_id, title, author, isbn, publisher, quantity)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "issssi",
        $category_id,
        $title,
        $author,
        $isbn,
        $publisher,
        $quantity
    );

    // Execute statement
    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../book.php");
        exit;

    } else {

        echo "Error adding book: " . htmlspecialchars(mysqli_stmt_error($stmt));

    }

    mysqli_stmt_close($stmt);
}

?>