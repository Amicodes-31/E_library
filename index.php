<?php
require_once __DIR__ . '/Config/db-connect.php';
require_once __DIR__ . '/Includes/Public-Header.php';

$sql = "SELECT id, title, author, publisher
        FROM books
        ORDER BY id DESC
        LIMIT 6";

$result = mysqli_query($conn, $sql);
?>

<!-- Hero Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center py-5">

            <div class="col-lg-7">
                <h1 class="display-4 fw-bold">
                    Knowledge Opens Doors to a Better Future.
                </h1>

                <p class="lead my-4">
                    Discover, explore and access educational books
                    through the Otukpo Tech Academy E-Library.
                </p>

                <a href="books.php" class="btn btn-library btn-lg">
                    Explore Books
                </a>

                <a href="about.php" class="btn btn-outline-success btn-lg ms-2">
                    Learn More
                </a>
            </div>

            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="p-5 rounded-4 text-center"
                     style="background-color:#203A31; color:#D7C69B;">
                    <h2 class="display-1">📚</h2>
                    <h3>Read. Learn. Grow.</h3>
                    <p class="text-white">
                        Your gateway to knowledge and opportunity.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="fw-bold">Welcome to Our E-Library</h2>

        <p class="lead mt-3">
            We are committed to making educational resources
            more accessible to students in our community.
        </p>

        <a href="about.php" class="btn btn-library mt-2">
            About Us
        </a>
    </div>
</section>

<!-- Featured Books -->
<section class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Recently Added Books</h2>

            <a href="books.php" class="text-success">
                View All Books
            </a>
        </div>

        <div class="row g-4">

            <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                <?php while ($book = mysqli_fetch_assoc($result)) { ?>

                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">

                            <div class="p-4 text-center"
                                 style="background:#203A31; color:#D7C69B;">
                                <h1>📖</h1>
                                <h6>OTUKPO TECH ACADEMY E-LIBRARY</h6>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($book['title']); ?>
                                </h5>

                                <p class="text-muted">
                                    Author:
                                    <?php echo htmlspecialchars($book['author']); ?>
                                </p>

                                <p class="text-muted">
                                    Publisher:
                                    <?php echo htmlspecialchars($book['publisher']); ?>
                                </p>

                                <a href="books.php"
                                   class="btn btn-library">
                                    Browse Catalogue
                                </a>
                            </div>

                        </div>
                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="col-12 text-center">
                    <p>No books have been added yet.</p>
                </div>

            <?php } ?>

        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 text-center"
         style="background-color:#203A31; color:white;">

    <div class="container">
        <h2>Start Your Learning Journey Today</h2>

        <p class="mt-3">
            Join our library community and discover new opportunities.
        </p>

        <a href="register.php" class="btn btn-light btn-lg mt-2">
            Become a Member
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="py-4 text-center">
    <div class="container">
        <p class="mb-1">Otukpo Tech Academy E-Library</p>
        <small>Knowledge for Growth and a Better Future.</small>
        <p class="mt-2 mb-0">
            &copy; <?php echo date('Y'); ?> E-Library. All rights reserved.
        </p>
        <p class="mt-2">
    <a href="Admin/login.php" class="text-success">
        Admin Login
    </a>
</p>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>