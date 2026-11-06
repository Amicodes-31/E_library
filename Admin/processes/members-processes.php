<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../../Config/db-connect.php';

// Process member registration
if (isset($_POST['register_member'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Set registration date
    $dateRegistered = date('Y-m-d H:i:s');

    // Prepare SQL statement
    $sql = "INSERT INTO members
            (name, email, phone, address, password, date_registered)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $name,
        $email,
        $phone,
        $address,
        $hashedPassword,
        $dateRegistered
    );

    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../members.php");
        exit;

    } else {

        echo "Error registering member: " . htmlspecialchars(mysqli_stmt_error($stmt));

    }

    mysqli_stmt_close($stmt);
}

?>