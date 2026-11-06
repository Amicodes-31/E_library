<?php

session_start();

require_once __DIR__ . '/Config/db-connect.php';

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM members WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {

        $member = mysqli_fetch_assoc($result);

        if (password_verify($password, $member['password'])) {

            session_regenerate_id(true);

            $_SESSION['member_id'] = $member['id'];
            $_SESSION['member_name'] = $member['name'];
            $_SESSION['member_email'] = $member['email'];

            header("Location: member-dashboard.php");
            exit;

        } else {
            $error = "Incorrect email or password.";
        }

    } else {
        $error = "Incorrect email or password.";
    }

    mysqli_stmt_close($stmt);
}

require_once __DIR__ . '/Includes/Public-Header.php';

?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow border-0 p-4">

                <h2 class="text-center fw-bold mb-3">
                    Member Login
                </h2>

                <p class="text-center text-muted">
                    Welcome back to the E-Library.
                </p>

                <?php if (!empty($error)) { ?>

                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>

                <?php } ?>

                <form method="POST" action="login.php">

                    <div class="mb-3">

                        <label class="form-label">Email Address</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Password</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        name="login"
                        class="btn btn-library w-100">
                        Login
                    </button>

                </form>

                <p class="text-center mt-3">
                    Don't have an account?
                    <a href="register.php">Register here</a>
                </p>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>