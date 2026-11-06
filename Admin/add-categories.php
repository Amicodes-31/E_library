<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../Config/db-connect.php';

// Load shared header
require_once __DIR__ . '/../Includes/Header.php';

?>

<div class="container-fluid">

    <div class="mb-4">
        <h2 style="color: #203A31;">Add Category</h2>

        <p class="text-muted">
            Create a new library category.
        </p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form action="processes/categories-processes.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Category Name</label>

                    <input
                        type="text"
                        name="category_name"
                        class="form-control"
                        placeholder="Enter category name"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                        placeholder="Enter category description"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    name="add_category"
                    class="btn btn-success"
                >
                    Add Category
                </button>

                <a href="categories.php" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>