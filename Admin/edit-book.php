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

// Get book ID
if (!isset($_GET['id'])) {
    header("Location: book.php");
    exit;
}

$id = (int) $_GET['id'];

// Retrieve book details
$sql = "SELECT * FROM books WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$book = mysqli_fetch_assoc($result);

if (!$book) {
    header("Location: book.php");
    exit;
}

// Retrieve categories
$categorySql = "SELECT * FROM categories ORDER BY category_name ASC";

$categoryResult = mysqli_query($conn, $categorySql);

// Load shared header
require_once __DIR__ . '/../Includes/Header.php';

?>

<div class="mb-4">

    <h2 style="color: #203A31;">Edit Book</h2>

    <p class="text-muted">
        Update the details of this book.
    </p>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="processes/edit-book-processes.php" method="POST">

            <input type="hidden" name="id"
                   value="<?php echo $book['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Book Title</label>
                <input type="text" name="title"
                       class="form-control"
                       value="<?php echo htmlspecialchars($book['title']); ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>
                <input type="text" name="author"
                       class="form-control"
                       value="<?php echo htmlspecialchars($book['author']); ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn"
                       class="form-control"
                       value="<?php echo htmlspecialchars($book['isbn']); ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Publisher</label>
                <input type="text" name="publisher"
                       class="form-control"
                       value="<?php echo htmlspecialchars($book['publisher']); ?>"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity"
                       class="form-control" min="0"
                       value="<?php echo $book['quantity']; ?>"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label">Category</label>

                <select name="category_id" class="form-select" required>

                    <?php while ($category = mysqli_fetch_assoc($categoryResult)) { ?>

                        <option value="<?php echo $category['id']; ?>"
                            <?php echo ($category['id'] == $book['category_id']) ? 'selected' : ''; ?>>

                            <?php echo htmlspecialchars($category['category_name']); ?>

                        </option>

                    <?php } ?>

                </select>
            </div>

            <button type="submit" name="update_book"
                    class="btn text-white"
                    style="background-color: #203A31;">
                Update Book
            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>