<?php

session_start();

require_once __DIR__ . '/../../Config/db-connect.php';
require_once __DIR__ . '/../../Classes/Admin.php';
$adminModel = new Admin($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=empty");
        exit;
    }

    $admin = $adminModel->login($email, $password);

if ($admin) {

    $admin_id = $admin['id'];
    $admin_name = $admin['name'];
    $admin_email = $admin['email'];

    
        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = $admin_name;
        $_SESSION['admin_email'] = $admin_email;

        

        header("Location: ../dashboard.php");
        exit;
    }
    else{
        header("location: ../login.php?error=invalid");
        exit;
    }
}