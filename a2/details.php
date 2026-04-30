<?php
$pageTitle = "Pet Details";
$activePage = "";
$basePath = "";
include 'includes/db_connect.inc';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    header('Location: pets.php');
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM pets WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_execute($stmt);
$result = mysqli_get_result($stmt);
$pet = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$pet) {
    include 'includes/header.inc';
    echo '<div class="alert alert-warning">Pet not found. <a href="pets.php">Back to Browse Pets</a></div>';
    include 'includes/footer.inc';
    exit;
}

$pageTitle = htmlspecialchars($pet['name']);
include 'includes/header.inc';
$status = strtolower($pet['status']);
?>

<div class="row g-4">
    <div class="col-md-5">
        <img
            src="assets/images/pets/<?php echo htmlspecialchars($pet['image'] ?? ''); ?>"
            alt="<?php echo htmlspecialchars($pet['name']); ?>"
            class="img-fluid rounded w-100"
        >
    </div>
    <div class="col-md-7">
        <h2 class="pet-detail-name mb-2"><?php echo htmlspecialchars($pet['name']); ?></h2>
        <div class="mb-3">
            <span class="badge badge-species me-1"><?php echo htmlspecialchars($pet['species']); ?></span>
            <span class="badge badge-<?php echo htmlspecialchars($status); ?>"><?php echo ucfirst($status); ?></span>
        </div>

        <table class="table table-bordered details-table mb-4">
            <tbody>
                <tr>
                    <th>Breed</th>
                    <td><?php echo htmlspecialchars($pet['breed'] ?? '—'); ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?php echo intval($pet['age_years']); ?> years, <?php echo intval($pet['age_months']); ?> months</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo htmlspecialchars($pet['gender']); ?></td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><?php echo htmlspecialchars($pet['size']); ?></td>
                </tr>
                <tr>
                    <th>Adoption Fee</th>
                    <td>$<?php echo number_format($pet['adoption_fee'], 2); ?></td>
                </tr>
            </tbody>
        </table>

        <h5 class="section-heading">
            <span class="material-icons">description</span> Description
        </h5>
        <p><?php echo nl2br(htmlspecialchars($pet['description'])); ?></p>

        <?php if (!empty($pet['health_info'])): ?>
        <h5 class="section-heading">
            <span class="material-icons">health_and_safety</span> Health Information
        </h5>
        <p><?php echo nl2br(htmlspecialchars($pet['health_info'])); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-4">
    <a href="pets.php" class="btn btn-indigo d-inline-flex align-items-center gap-1">
        <span class="material-icons icon-sm">arrow_back</span> Back to Browse Pets
    </a>
</div>

<?php include 'includes/footer.inc'; ?>
