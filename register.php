<?php

session_start();

require_once __DIR__ . '/Config/db-connect.php';

$error = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if email already exists
    $check = mysqli_prepare($conn, "SELECT id FROM members WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    $existing = mysqli_stmt_get_result($check);

   if ($password !== $confirm_password) {

    $error = "Passwords do not match.";

} elseif (mysqli_num_rows($existing) > 0) {

    $error = "This email is already registered.";

} else {
        // Securely hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO members
                (name, email, phone, address, password, date_registered)
                VALUES (?, ?, ?, ?, ?, CURDATE())";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $name,
            $email,
            $phone,
            $address,
            $hashedPassword
        );

        if (mysqli_stmt_execute($stmt)) {

            header("Location: login.php?registered=1");
            exit;

        } else {

            $error = "Registration failed. Please try again.";

        }

        mysqli_stmt_close($stmt);
    }

    mysqli_stmt_close($check);
}

require_once __DIR__ . '/Includes/Public-Header.php';

?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0 p-4">

                <h2 class="text-center fw-bold mb-3">
                    Create Your Account
                </h2>

                <p class="text-center text-muted">
                    Join the OTUKPO TECH ACADEMY E-LIBRARY.
                </p>

                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php } ?>

                <form method="POST" action="register.php">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address"
                                  class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                               class="form-control"
                               minlength="6" required>
                    </div>

                    <div class="mb-3">
    <label class="form-label">Confirm Password</label>
    <input type="password" name="confirm_password"
           class="form-control"
           minlength="6" required>
</div>

                    <button type="submit" name="register"
                            class="btn btn-library w-100">
                        Register
                    </button>

                </form>

                <p class="text-center mt-3">
                    Already have an account?
                    <a href="login.php">Login here</a>
                </p>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>