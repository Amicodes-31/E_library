<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
require_once __DIR__ . '/../Config/db-connect.php';

// Load Member class
require_once __DIR__ . '/../Classes/Member.php';

$memberModel = new Member($conn);

$result = $memberModel->getAllMembers();

?>

<!-- Page Heading -->
<div class="mb-4">

    <h2 style="color: #203A31;">Manage Members</h2>

    <p class="text-muted">
        View registered library members.
    </p>

</div>

<!-- Members Table -->
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <h5 class="mb-4" style="color: #203A31;">
            Registered Members
        </h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead style="background-color: #203A31; color: white;">

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Date Registered</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (mysqli_num_rows($result) > 0) { ?>

                        <?php while ($member = mysqli_fetch_assoc($result)) { ?>

                            <tr>

                                <td><?php echo $member['id']; ?></td>

                                <td><?php echo htmlspecialchars($member['name']); ?></td>

                                <td><?php echo htmlspecialchars($member['email']); ?></td>

                                <td><?php echo htmlspecialchars($member['phone']); ?></td>

                                <td><?php echo htmlspecialchars($member['address']); ?></td>

                                <td><?php echo htmlspecialchars($member['date_registered']); ?></td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No members registered yet.
                            </td>
                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>