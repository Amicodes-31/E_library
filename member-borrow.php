<?php

session_start();

require_once __DIR__ . '/Config/db-connect.php';

// Ensure member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['request_borrow'])) {

    $member_id = (int) $_SESSION['member_id'];
    $book_id = (int) $_POST['book_id'];

    // Check book availability
    $sql = "SELECT quantity FROM books WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $book_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $book = mysqli_fetch_assoc($result);

    if (!$book || $book['quantity'] <= 0) {
        die("This book is currently unavailable.");
    }

    // Prevent duplicate active requests
    $sql = "SELECT id FROM borrowings
            WHERE member_id = ?
            AND book_id = ?
            AND status IN ('Pending', 'Borrowed')";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $member_id, $book_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        die("You already have an active request for this book.");
    }

    // Save borrowing request
    $sql = "INSERT INTO borrowings
            (member_id, book_id, borrow_date, due_date, status)
            VALUES (?, ?, NULL, NULL, 'Pending')";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $member_id, $book_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: member-dashboard.php");
        exit;
    } else {
        die("Unable to submit borrowing request.");
    }
}

?>