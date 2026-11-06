<?php

session_start();

// If admin is already logged in, go to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: ../dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card-header bg-success text-white text-center">
   

    <h2>Admin Login</h2>

    <?php if (isset($_GET['error'])) { ?>

    <div class="alert alert-danger">
        <?php
        if ($_GET['error'] === 'invalid') {
            echo "Invalid email or password. Please try again.";
        } elseif ($_GET['error'] === 'empty') {
            echo "Please fill in all fields.";
        }
        ?>
    </div>

<?php } ?>
    </div>

    <form action="processes/login-processes.php" method="POST">
        <div class="mb-3">

        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>

        <br><br>

        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>

        <br><br>
        
        <button type="submit" name="login" class="btn btn-success">Login</button>
        </div>

    </form>

    </div>
    </div>

</body>
</html>
</body>
</html>