<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Protect the page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../Config/db-connect.php';

// Retrieve categories
$sql = "SELECT * FROM categories ORDER BY category_name ASC";
$result = mysqli_query($conn, $sql);

// Load shared header
require_once __DIR__ . '/../Includes/Header.php';

?>

<div class="mb-4">

    <h2 style="color: #203A31;">Add New Book</h2>

    <p class="text-muted">
        Add a new book to your library collection.
    </p>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="processes/book-processes.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Book Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Publisher</label>
                <input type="text" name="publisher" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" min="0" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Category</label>

                <select name="category_id" class="form-select" required>

                    <option value="">Select Category</option>

                    <?php while ($category = mysqli_fetch_assoc($result)) { ?>

                        <option value="<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['category_name']); ?>
                        </option>

                    <?php } ?>

                </select>
            </div>

            <button type="submit" name="add_book"
                    class="btn text-white"
                    style="background-color: #203A31;">
                Add Book
            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>