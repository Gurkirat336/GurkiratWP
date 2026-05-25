<?php
session_start();
$pageTitle = "Owner Profile";
$activePage = "";
$basePath = "";
include 'includes/db_connect.inc';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id === 0) {
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT user_id, username, email, phone, location, joined_at FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $u_id, $u_username, $u_email, $u_phone, $u_location, $u_joined_at);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$found) {
    header("Location: index.php");
    exit;
}

include 'includes/header.inc';
?>

<div class="owner-page-header">
    <h2><?php echo htmlspecialchars($u_username); ?></h2>
    <p>
        <span class="material-icons icon-sm">calendar_today</span>
        Member since <?php echo date('F Y', strtotime($u_joined_at)); ?>
    </p>
    <?php if ($u_location): ?>
    <p>
        <span class="material-icons icon-sm">location_on</span>
        <?php echo htmlspecialchars($u_location); ?>
    </p>
    <?php endif; ?>
    <?php if ($u_phone): ?>
    <p>
        <span class="material-icons icon-sm">phone</span>
        <?php echo htmlspecialchars($u_phone); ?>
    </p>
    <?php endif; ?>
    <p>
        <span class="material-icons icon-sm">email</span>
        <a href="mailto:<?php echo htmlspecialchars($u_email); ?>" class="owner-email-link"><?php echo htmlspecialchars($u_email); ?></a>
    </p>
</div>

<h3 class="home-section-title">
    <span class="material-icons">pets</span> Pets Listed by <?php echo htmlspecialchars($u_username); ?>
</h3>

<div class="row g-3">
<?php
$sql = "SELECT pet_id, name, species, adoption_fee, status, image_path FROM pets WHERE user_id = " . $u_id . " ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$pet_count = 0;
while ($pet = mysqli_fetch_assoc($result)) {
    $pet_count++;
    $statusClass = 'badge-status-' . strtolower($pet['status']);
?>
    <div class="col-6 col-md-3">
        <div class="pet-card">
            <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>">
            <div class="card-body">
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="pet-name-link"><?php echo htmlspecialchars($pet['name']); ?></a>
                <div class="d-flex gap-1 mb-1 mt-1">
                    <span class="badge-species"><?php echo htmlspecialchars($pet['species']); ?></span>
                    <span class="<?php echo $statusClass; ?>"><?php echo htmlspecialchars($pet['status']); ?></span>
                </div>
                <span class="pet-price">$<?php echo number_format($pet['adoption_fee'], 2); ?></span>
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="btn-primary-custom btn-sm w-100 justify-content-center mt-1">
                    <span class="material-icons icon-sm">pets</span> View Details
                </a>
                <?php if (isset($_SESSION['user_id']) && intval($_SESSION['user_id']) === $u_id): ?>
                <a href="edit.php?id=<?php echo $pet['pet_id']; ?>" class="btn-secondary-custom btn-sm w-100 justify-content-center mt-1">
                    <span class="material-icons icon-sm">edit</span> Edit
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($pet_count === 0): ?>
    <div class="col-12">
        <p class="text-muted">This owner has not listed any pets yet.</p>
    </div>
<?php endif; ?>
</div>

<?php include 'includes/footer.inc'; ?>
