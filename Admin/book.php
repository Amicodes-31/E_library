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
require_once __DIR__ . '/../Config/db-connect.php';
require_once __DIR__ . '/../Classes/Book.php';

$bookModel = new Book($conn);

$result = $bookModel->getAllBooks();


// Retrieve all books
$sql = "SELECT * FROM books ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

// Load shared header
require_once __DIR__ . '/../includes/header.php';

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="color: #203A31;">Manage Books</h2>
        <p class="text-muted">View and manage books in your library.</p>
    </div>

    <a href="add-book.php" class="btn text-white"
       style="background-color: #203A31;">
        + Add Book
    </a>
</div>

<!-- Book Table -->
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <h5 class="mb-4" style="color: #203A31;">
            Book Collection
        </h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead style="background-color: #203A31; color: white;">

                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                        <?php while ($book = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td>
                                    <?php echo $book['id']; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($book['title']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($book['author']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($book['publisher']); ?>
                                </td>

                                <td>
                                    <span class="badge rounded-pill"
                                          style="background-color: #D7C69B; color: #203A31;">
                                        <?php echo $book['quantity']; ?>
                                    </span>
                                </td>
                               <td>
    <a href="edit-book.php?id=<?php echo $book['id']; ?>"
       class="btn btn-sm btn-warning">
        Edit
    </a>

    <a href="processes/delete-book-processes.php?id=<?php echo $book['id']; ?>"
       class="btn btn-sm btn-danger"
       onclick="return confirm('Are you sure you want to delete this book?');">
        Delete
    </a>
</td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No books found.
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>