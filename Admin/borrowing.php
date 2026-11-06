<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../config/db-connect.php';

// Load Borrowing class
require_once __DIR__ . '/../Classes/borrowing.php';

$borrowingModel = new Borrowing($conn);

$result = $borrowingModel->getAllBorrowings();

// Load shared header
require_once __DIR__ . '/../includes/Header.php';

?>

<!-- Page Heading -->
<div class="mb-4">

    <h2 style="color: #203A31;">Manage Borrowings</h2>

    <p class="text-muted">
        Track borrowed books and their return dates.
    </p>

</div>

<!-- Borrowings Table -->
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <h5 class="mb-4" style="color: #203A31;">
            Borrowing Records
        </h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead style="background-color: #203A31; color: white;">

                    <tr>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Book</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                        <?php while ($borrowing = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td>
                                    <?php echo $borrowing['id']; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($borrowing['member_name']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($borrowing['book_title']); ?>
                                </td>

                                <td>
                                    <?php echo !empty($borrowing['borrow_date'])
                                        ? htmlspecialchars($borrowing['borrow_date'])
                                        : 'Pending approval'; ?>
                                </td>

                                <td>
                                    <?php echo !empty($borrowing['due_date'])
                                        ? htmlspecialchars($borrowing['due_date'])
                                        : 'Not assigned'; ?>
                                </td>

                                <!-- Return Date -->
                                <td>
                                    <?php
                                    echo !empty($borrowing['return_date'])
                                        ? htmlspecialchars($borrowing['return_date'])
                                        : 'Not returned';
                                    ?>
                                </td>

                                <!-- Status -->
                                <td>
                                    <?php echo htmlspecialchars($borrowing['status']); ?>
                                </td>

                                <!-- Action -->
                                <td>

                                    <?php if ($borrowing['status'] === 'Pending') { ?>

                                        <form action="processes/Borrowing-processes.php" method="POST">

                                            <input type="hidden"
                                                   name="borrowing_id"
                                                   value="<?php echo (int)$borrowing['id']; ?>">

                                            <button type="submit"
                                                    name="approve_request"
                                                    class="btn btn-success btn-sm mb-1">
                                                Approve
                                            </button>

                                            <button type="submit"
                                                    name="reject_request"
                                                    class="btn btn-danger btn-sm">
                                                Reject
                                            </button>

                                        </form>

                                    <?php } elseif ($borrowing['status'] === 'Borrowed') { ?>

                                        <form action="processes/Return-processes.php" method="POST">

                                            <input type="hidden"
                                                   name="borrowing_id"
                                                   value="<?php echo (int)$borrowing['id']; ?>">

                                            <button type="submit"
                                                    name="return_book"
                                                    class="btn btn-success btn-sm">
                                                Return Book
                                            </button>

                                        </form>

                                    <?php } elseif ($borrowing['status'] === 'Returned') { ?>

                                        <span class="text-success">
                                            Returned
                                        </span>

                                    <?php } elseif ($borrowing['status'] === 'Rejected') { ?>

                                        <span class="text-danger">
                                            Rejected
                                        </span>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No borrowing records found.
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../includes/Footer.php'; ?>