<?php

require_once __DIR__ . '/Config/db-connect.php';
require_once __DIR__ . '/Includes/Public-Header.php';

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

$sql = "SELECT books.*, categories.category_name
        FROM books
        LEFT JOIN categories ON books.category_id = categories.id
        WHERE books.title LIKE ?
        OR books.author LIKE ?
        ORDER BY books.id DESC";

$stmt = mysqli_prepare($conn, $sql);

$searchTerm = "%" . $search . "%";

mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<section class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h1 class="fw-bold">Our Book Catalogue</h1>
            <p class="lead">Discover books and explore new knowledge.</p>
        </div>

        <form method="GET" action="books.php" class="mb-5">
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search by book title or author..."
                       value="<?php echo htmlspecialchars($search); ?>">

                <button class="btn btn-library" type="submit">
                    Search
                </button>
            </div>
        </form>

        <div class="row g-4">

            <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                <?php while ($book = mysqli_fetch_assoc($result)) { ?>

                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">

                            <div class="p-4 text-center"
                                 style="background:#203A31; color:#D7C69B;">
                                <h1>📚</h1>
                                <h6>OTUKPO TECH ACADEMY E-LIBRARY</h6>
                            </div>

                            <?php if (!empty($book['book_image'])) { ?>
                     <img src="assets/images/<?php echo htmlspecialchars($book['book_image']); ?>"
                   class="card-img-top"
                  alt="<?php echo htmlspecialchars($book['title']); ?>"
                 style="height: 220px; object-fit: contain;">
            <?php } ?>

                            <div class="card-body">

                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($book['title']); ?>
                                </h5>

                                <p class="text-muted">
                                    Author: <?php echo htmlspecialchars($book['author']); ?>
                                </p>

                                <p>
                                    Category:
                                    <?php echo htmlspecialchars($book['category_name'] ?? 'Uncategorized'); ?>
                                </p>

                                <p>
                                    Available Copies:
                                    <?php echo (int)$book['quantity']; ?>
                                </p>

                                <?php if (isset($_SESSION['member_id']) && $book['quantity'] > 0) { ?>

    <form action="member-borrow.php" method="POST">
        <input type="hidden" name="book_id"
               value="<?php echo (int)$book['id']; ?>">

        <button type="submit" name="request_borrow"
                class="btn btn-library w-100">
            Request to Borrow
        </button>
    </form>

<?php } elseif (!isset($_SESSION['member_id'])) { ?>

    <a href="login.php" class="btn btn-outline-secondary w-100">
        Login to Borrow
    </a>

<?php } else { ?>

    <button class="btn btn-secondary w-100" disabled>
        Unavailable
    </button>

<?php } ?>

                            </div>
                        </div>
                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="col-12 text-center">
                    <p>No books found.</p>
                </div>

            <?php } ?>

        </div>

    </div>
</section>

<footer class="py-4 text-center">
    <p class="mb-1">OTUKPO TECH ACADEMY E-LIBRARY</p>
    <small>Knowledge Without Boundaries.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>