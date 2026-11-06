
<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../../Config/db-connect.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {

    $category_name = trim($_POST['category_name']);
    $description = trim($_POST['description']);
    

}


?>