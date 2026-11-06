<?php

session_start();

// Clear member session details
unset(
    $_SESSION['member_id'],
    $_SESSION['member_name'],
    $_SESSION['member_email']
);

// Destroy the session
session_destroy();

// Redirect to homepage
header("Location: index.php");
exit;

?>