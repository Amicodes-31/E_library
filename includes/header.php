<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>E-Library Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body {
            background-color: #F5F3ED;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #203A31;
            flex-shrink: 0;
        }

        .sidebar h4 {
            color: #D7C69B;
            font-weight: bold;
        }

        .sidebar .nav-link {
            color: #FFFFFF;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .sidebar .nav-link:hover {
            background-color: #172B25;
            color: #D7C69B;
        }

        .sidebar .nav-link.active {
            background-color: #D7C69B;
            color: #203A31;
            font-weight: bold;
        }

        .main-content {
            min-width: 0;
        }

    </style>

</head>

<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar p-3">

        <h4 class="mb-5">E-LIBRARY</h4>

        <p class="text-uppercase small text-white-50">
            Main Menu
        </p>

        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="dashboard.php"
                   class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="book.php"
                   class="nav-link <?php echo ($currentPage == 'book.php') ? 'active' : ''; ?>">
                    Manage Book
                </a>
            </li>

            <li class="nav-item">
                <a href="categories.php"
                   class="nav-link <?php echo ($currentPage == 'categories.php') ? 'active' : ''; ?>">
                    Categories
                </a>
            </li>

            <li class="nav-item">
                <a href="members.php"
                   class="nav-link <?php echo ($currentPage == 'members.php') ? 'active' : ''; ?>">
                    Members
                </a>
            </li>

            <li class="nav-item">
                <a href="borrowing.php"
                   class="nav-link <?php echo ($currentPage == 'borrowing.php') ? 'active' : ''; ?>">
                    Borrowings
                </a>
            </li>

            <li class="nav-item mt-5">
                <a href="logout.php" class="nav-link">
                    Logout
                </a>
            </li>

        </ul>

    </div>

    <!-- Main Content Area -->
    <div class="main-content flex-grow-1 p-4">