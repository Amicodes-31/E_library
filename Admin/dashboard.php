<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../Config/db-connect.php';

// Count total books
$booksResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
$booksData = mysqli_fetch_assoc($booksResult);
$totalBooks = $booksData['total'];

// Count total categories
$categoriesResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories");
$categoriesData = mysqli_fetch_assoc($categoriesResult);
$totalCategories = $categoriesData['total'];

// Count total members
$membersResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM members");
$membersData = mysqli_fetch_assoc($membersResult);
$totalMembers = $membersData['total'];

// Count total borrowings
$borrowingsResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM borrowings");
$borrowingsData = mysqli_fetch_assoc($borrowingsResult);
$totalBorrowings = $borrowingsData['total'];

require_once __DIR__ . '/../Includes/Header.php';

?>

<!-- Welcome Section -->
<div class="bg-white p-4 rounded-4 shadow-sm mb-4">

    <h2 style="color: #203A31;">Admin Dashboard</h2>

    <h4 class="mt-3">
        Welcome,
        <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!
    </h4>

    <p class="text-muted mb-0">
        Welcome to your E-Library Management System.
    </p>

</div>

<!-- Statistics Cards -->
<div class="row g-4">

    <!-- Books -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="text-muted">Total Books</h6>
                <h2 style="color: #203A31;">
                    <?php echo $totalBooks; ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="text-muted">Categories</h6>
                <h2 style="color: #203A31;">
                    <?php echo $totalCategories; ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Members -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="text-muted">Total Members</h6>
                <h2 style="color: #203A31;">
                    <?php echo $totalMembers; ?>
                </h2>
            </div>
        </div>
    </div>

    <!-- Borrowings -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="text-muted">Borrowed Books</h6>
                <h2 style="color: #203A31;">
                    <?php echo $totalBorrowings; ?>
                </h2>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>