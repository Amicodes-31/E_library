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

// Load shared header
require_once __DIR__ . '/../Includes/Header.php';

?>

<div class="mb-4">

    <h2 style="color: #203A31;">Register New Member</h2>

    <p class="text-muted">
        Add a new member to the E-Library.
    </p>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="processes/members-processes.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" name="register_member"
                    class="btn text-white"
                    style="background-color: #203A31;">
                Register Member
            </button>

        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>