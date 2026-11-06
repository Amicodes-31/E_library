<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../Config/db-connect.php';
require_once __DIR__ . '/../Classes/Category.php';

$categoryModel = new Category($conn);

$result = $categoryModel->getAllCategories();



// Load shared header
require_once __DIR__ . '/../Includes/Header.php';

?>

<!-- Page Heading -->
<div class="mb-4">

    <h2 style="color: #203A31;">Manage Categories</h2>

    <p class="text-muted">
        View and manage your library categories.
    </p>

</div>

<!-- Categories Table -->
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <h5 class="mb-4" style="color: #203A31;">
            Category List
        </h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead style="background-color: #203A31; color: white;">

                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (mysqli_num_rows($result) > 0) { ?>

                        <?php while ($category = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td><?php echo $category['id']; ?></td>

                                <td>
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($category['description']); ?>
                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                No categories found.
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>