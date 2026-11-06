<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../../Config/db-connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_book'])) {

    $borrowing_id = (int) $_POST['borrowing_id'];

    mysqli_begin_transaction($conn);

    try {

        // Find the borrowing record
        $sql = "SELECT book_id, status
                FROM borrowings
                WHERE id = ?
                FOR UPDATE";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $borrowing_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $borrowing = mysqli_fetch_assoc($result);

        if (!$borrowing) {
            throw new Exception("Borrowing record not found.");
        }

        if ($borrowing['status'] !== 'Borrowed') {
            throw new Exception("This book has already been returned.");
        }

        $book_id = (int) $borrowing['book_id'];
        $return_date = date('Y-m-d');

        // Update borrowing record
        $sql = "UPDATE borrowings
                SET return_date = ?, status = 'Returned'
                WHERE id = ? AND status = 'Borrowed'";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $return_date, $borrowing_id);

        if (!mysqli_stmt_execute($stmt) ||
            mysqli_stmt_affected_rows($stmt) !== 1) {
            throw new Exception("Unable to update borrowing record.");
        }

        // Restore book quantity
        $sql = "UPDATE books
                SET quantity = quantity + 1
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $book_id);

        if (!mysqli_stmt_execute($stmt) ||
            mysqli_stmt_affected_rows($stmt) !== 1) {
            throw new Exception("Unable to restore book quantity.");
        }

        mysqli_commit($conn);

        header("Location: ../borrowing.php");
        exit;

    } catch (Throwable $e) {

        mysqli_rollback($conn);

        die("Return failed: " . htmlspecialchars($e->getMessage()));
    }
}

?>