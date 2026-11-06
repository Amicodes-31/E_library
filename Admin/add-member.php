<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../Config/db-connect.php';
require_once __DIR__ . '/../Classes/Member.php';

$memberModel = new Member($conn);
$result = $memberModel->getAllMembers();

$totalMembers = mysqli_num_rows($result);

?>

<div class="container-fluid py-4">

    <!-- Page Heading -->
    <div class="mb-4">
        <h2 class="fw-bold" style="color:#203A31;">
            Members Management
        </h2>
        <p class="text-muted">
            Manage and monitor registered library members.
        </p>
    </div>

    <!-- Summary Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">
                                Total Registered Members
                            </p>
                            <h2 class="fw-bold mb-0"
                                style="color:#203A31;">
                                <?php echo $totalMembers; ?>
                            </h2>
                        </div>

                        <div class="rounded-3 p-3"
                             style="background:#E8F0EC;">
                            <span style="font-size:28px;">👥</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between
                        align-items-center gap-3 mb-4">

                <div>
                    <h5 class="fw-bold mb-1"
                        style="color:#203A31;">
                        Registered Members
                    </h5>
                    <small class="text-muted">
                        Member records and registration details
                    </small>
                </div>

                <div style="max-width:300px; width:100%;">
                    <input type="text"
                           id="memberSearch"
                           class="form-control rounded-3"
                           placeholder="Search members...">
                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle"
                       id="membersTable">

                    <thead>
                        <tr style="background:#203A31; color:white;">
                            <th class="py-3">ID</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Address</th>
                            <th class="py-3">Date Registered</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if ($totalMembers > 0) { ?>

                        <?php while ($member = mysqli_fetch_assoc($result)) { ?>

                            <tr>
                                <td class="fw-semibold">
                                    <?php echo htmlspecialchars($member['id']); ?>
                                </td>

                                <td class="fw-semibold">
                                    <?php echo htmlspecialchars($member['name']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($member['email']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($member['phone']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($member['address']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($member['date_registered']); ?>
                                </td>
                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>
                            <td colspan="6"
                                class="text-center text-muted py-5">
                                No members registered yet.
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

                <p id="noSearchResults"
                   class="text-center text-muted py-3"
                   style="display:none;">
                    No matching members found.
                </p>

            </div>

        </div>
    </div>

</div>

<script>
document.getElementById('memberSearch').addEventListener('input', function() {

    let searchValue = this.value.toLowerCase();

    let rows = document.querySelectorAll('#membersTable tbody tr');

    let visibleCount = 0;

    rows.forEach(function(row) {

        let text = row.innerText.toLowerCase();

        if (text.includes(searchValue)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }

    });

    document.getElementById('noSearchResults').style.display =
        visibleCount === 0 ? 'block' : 'none';

});
</script>

<?php require_once __DIR__ . '/../Includes/Footer.php'; ?>