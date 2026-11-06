<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../Config/db-connect.php';

// Retrieve registered members
$members = mysqli_query($conn, "SELECT id, name FROM members");

// Retrieve books
$books = mysqli_query($conn, "SELECT id, title, quantity FROM books");

require_once __DIR__ . '/../Includes/Header.php';

?>

<div class="container-fluid">

    <h2 class="mb-4">Register Book Borrowing</h2>

    <div class="card shadow-sm p-4">

        <form action="processes/borrowing-processes.php" method="POST">

            <!-- Select Member -->
            <div class="mb-3">
                <label class="form-label">Select Member</label>

                <select name="member_id" class="form-select" required>
                    <option value="">Choose a member</option>

                    <?php while ($member = mysqli_fetch_assoc($members)) { ?>

                        <option value="<?php echo $member['id']; ?>">
                            <?php echo htmlspecialchars($member['name']); ?>
                        </option>

                    <?php } ?>

                </select>
            </div>

            <!-- Select Book -->
            <div class="mb-3">
                <label class="form-label">Select Book</label>

                <select name="book_id" class="form-select" required>
                    <option value="">Choose a book</option>

                    <?php while ($book = mysqli_fetch_assoc($books)) { ?>

                        <option value="<?php echo $book['id']; ?>">
                            <?php echo htmlspecialchars($book['title']); ?>
                            (Available: <?php echo $book['quantity']; ?>)
                        </option>

                    <?php } ?>

                </select>
            </div>

            <button type="submit" name="borrow_book" class="btn btn-success">
                Register Borrowing
            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>
