<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../../Config/db-connect.php';


// ==================================
// APPROVE BORROWING REQUEST
// ==================================

if (isset($_POST['approve_request'])) {

    $borrowing_id = (int) $_POST['borrowing_id'];

    mysqli_begin_transaction($conn);

    try {

        // Find the pending borrowing request
        $sql = "SELECT * FROM borrowings
                WHERE id = ? AND status = 'Pending'
                FOR UPDATE";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $borrowing_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $borrowing = mysqli_fetch_assoc($result);

        if (!$borrowing) {
            throw new Exception("Borrowing request not found.");
        }

        $book_id = (int) $borrowing['book_id'];

        // Check available book quantity
        $sql = "SELECT quantity FROM books
                WHERE id = ? FOR UPDATE";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $book_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $book = mysqli_fetch_assoc($result);

        if (!$book || $book['quantity'] <= 0) {
            throw new Exception("This book is no longer available.");
        }

        // Reduce book quantity
        $sql = "UPDATE books
                SET quantity = quantity - 1
                WHERE id = ? AND quantity > 0";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $book_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) !== 1) {
            throw new Exception("Unable to update book quantity.");
        }

        // Set borrowing date and 14-day due date
        $sql = "UPDATE borrowings
                SET borrow_date = CURDATE(),
                    due_date = DATE_ADD(CURDATE(), INTERVAL 14 DAY),
                    status = 'Borrowed'
                WHERE id = ? AND status = 'Pending'";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $borrowing_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) !== 1) {
            throw new Exception("Unable to approve borrowing request.");
        }

        mysqli_commit($conn);

        header("Location: ../borrowing.php");
        exit;

    } catch (Throwable $e) {

        mysqli_rollback($conn);

        die("Approval failed: " . htmlspecialchars($e->getMessage()));
    }
}


// ==================================
// REJECT BORROWING REQUEST
// ==================================

if (isset($_POST['reject_request'])) {

    $borrowing_id = (int) $_POST['borrowing_id'];

    $sql = "UPDATE borrowings
            SET status = 'Rejected'
            WHERE id = ? AND status = 'Pending'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $borrowing_id);

    if (mysqli_stmt_execute($stmt) &&
        mysqli_stmt_affected_rows($stmt) === 1) {

        header("Location: ../borrowing.php");
        exit;

    } else {

        die("Unable to reject borrowing request.");
    }
}


// ==================================
// ADMIN MANUAL BORROWING
// ==================================

if (isset($_POST['borrow_book'])) {

    $member_id = (int) $_POST['member_id'];
    $book_id = (int) $_POST['book_id'];

    mysqli_begin_transaction($conn);

    try {

        // Check book availability
        $sql = "SELECT quantity FROM books
                WHERE id = ? FOR UPDATE";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $book_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $book = mysqli_fetch_assoc($result);

        if (!$book) {
            throw new Exception("Book not found.");
        }

        if ($book['quantity'] <= 0) {
            throw new Exception("This book is currently unavailable.");
        }

        // Set borrowing dates
        $borrow_date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime('+14 days'));
        $status = "Borrowed";

        // Insert borrowing record
        $sql = "INSERT INTO borrowings
                (member_id, book_id, borrow_date, due_date, status)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "iisss",
            $member_id,
            $book_id,
            $borrow_date,
            $due_date,
            $status
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Unable to register borrowing.");
        }

        // Reduce book quantity
        $sql = "UPDATE books
                SET quantity = quantity - 1
                WHERE id = ? AND quantity > 0";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $book_id);

        if (!mysqli_stmt_execute($stmt) ||
            mysqli_stmt_affected_rows($stmt) !== 1) {

            throw new Exception("Unable to update book quantity.");
        }

        mysqli_commit($conn);

        header("Location: ../borrowing.php");
        exit;

    } catch (Throwable $e) {

        mysqli_rollback($conn);

        die("Borrowing failed: " . htmlspecialchars($e->getMessage()));
    }
}

?>