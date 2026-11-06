<?php

session_start();

// Protect the dashboard
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/Config/db-connect.php';

// Get member borrowing records
$member_id = (int) $_SESSION['member_id'];

$sql = "SELECT borrowings.*, books.title, books.author
        FROM borrowings
        INNER JOIN books ON borrowings.book_id = books.id
        WHERE borrowings.member_id = ?
        ORDER BY borrowings.id DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $member_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

require_once __DIR__ . '/Includes/Public-Header.php';

?>

<div class="container py-5">

    <div class="mb-5">
        <h2 class="fw-bold">
            Welcome, <?php echo htmlspecialchars($_SESSION['member_name']); ?>!
        </h2>

        <p class="text-muted">
            Welcome to your E-Library dashboard.
            Explore books and keep track of your borrowing records.
        </p>
    </div>

    <div class="row g-4 mb-5">

        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4 h-100">
                <h5>Browse Books</h5>
                <p>Explore our available educational books.</p>
                <a href="books.php" class="btn btn-library">
                    Browse Catalogue
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4 h-100">
                <h5>My Borrowing Records</h5>
                <p>View your book borrowing history and status.</p>
                <a href="#borrowings" class="btn btn-outline-success">
                    View Records
                </a>
            </div>
        </div>

    </div>

    <section id="borrowings">

        <h3 class="fw-bold mb-4">My Borrowing History</h3>

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Borrow Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                                <?php while ($borrowing = mysqli_fetch_assoc($result)) { ?>

                                    <tr>

                                        <td>
                                            <?php echo htmlspecialchars($borrowing['title']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($borrowing['author']); ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo !empty($borrowing['borrow_date'])
                                                ? htmlspecialchars($borrowing['borrow_date'])
                                                : 'Awaiting approval';
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo !empty($borrowing['due_date'])
                                                ? htmlspecialchars($borrowing['due_date'])
                                                : 'Not assigned';
                                            ?>
                                        </td>

                                        <td>

                                            <?php if ($borrowing['status'] === 'Pending') { ?>

                                                <span class="badge bg-warning text-dark">
                                                    Pending Approval
                                                </span>

                                            <?php } elseif ($borrowing['status'] === 'Borrowed') { ?>

                                                <span class="badge bg-success">
                                                    Borrowed
                                                </span>

                                            <?php } elseif ($borrowing['status'] === 'Returned') { ?>

                                                <span class="badge bg-primary">
                                                    Returned
                                                </span>

                                            <?php } elseif ($borrowing['status'] === 'Rejected') { ?>

                                                <span class="badge bg-danger">
                                                    Rejected
                                                </span>

                                            <?php } ?>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="5" class="text-center">
                                        You have no borrowing records yet.
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

</div>

<footer class="py-4 text-center">
    <p class="mb-1">OTUKPO TECH ACADEMY E-LIBRARY</p>
    <small>Knowledge Without Boundaries.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>