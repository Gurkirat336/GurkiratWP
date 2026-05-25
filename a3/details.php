<?php
session_start();
$pageTitle = "Pet Details";
$activePage = "";
$basePath = "";
include 'includes/db_connect.inc';

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $pet_id = intval($_GET['id']);
    $stmt = mysqli_prepare($conn, "SELECT image_path, user_id FROM pets WHERE pet_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $pet_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image_path, $owner_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($owner_id === intval($_SESSION['user_id'])) {
        $stmt = mysqli_prepare($conn, "DELETE FROM pets WHERE pet_id = ? AND user_id = ?");
        $user_id = intval($_SESSION['user_id']);
        mysqli_stmt_bind_param($stmt, 'ii', $pet_id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($image_path && file_exists('assets/images/pets/' . $image_path)) {
            unlink('assets/images/pets/' . $image_path);
        }

        $_SESSION['flash_message'] = "Pet deleted successfully.";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php");
        exit;
    }
}

$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($pet_id === 0) {
    header("Location: pets.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT p.pet_id, p.name, p.species, p.breed, p.age_years, p.age_months, p.gender, p.size, p.description, p.health_info, p.image_path, p.adoption_fee, p.status, p.user_id, u.username, u.email, u.phone, u.location FROM pets p JOIN users u ON p.user_id = u.user_id WHERE p.pet_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $pet_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $p_id, $p_name, $p_species, $p_breed, $p_age_years, $p_age_months, $p_gender, $p_size, $p_description, $p_health_info, $p_image_path, $p_adoption_fee, $p_status, $p_user_id, $p_username, $p_email, $p_phone, $p_location);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$found) {
    header("Location: pets.php");
    exit;
}

include 'includes/header.inc';
?>

<div class="row g-4">
    <div class="col-12 col-md-5">
        <img src="assets/images/pets/<?php echo htmlspecialchars($p_image_path); ?>"
             alt="<?php echo htmlspecialchars($p_name); ?>"
             class="details-pet-img img-fluid">
    </div>
    <div class="col-12 col-md-7">
        <h2 class="details-heading"><?php echo htmlspecialchars($p_name); ?></h2>
        <div class="d-flex gap-2 mb-3">
            <span class="badge-species"><?php echo htmlspecialchars($p_species); ?></span>
            <span class="badge-status-<?php echo strtolower($p_status); ?>"><?php echo htmlspecialchars($p_status); ?></span>
        </div>

        <table class="table table-bordered mb-3">
            <tbody>
                <tr><th>Breed:</th><td><?php echo htmlspecialchars($p_breed); ?></td></tr>
                <tr><th>Age:</th><td><?php echo $p_age_years; ?> years, <?php echo $p_age_months; ?> months</td></tr>
                <tr><th>Gender:</th><td><?php echo htmlspecialchars($p_gender); ?></td></tr>
                <tr><th>Size:</th><td><?php echo htmlspecialchars($p_size); ?></td></tr>
                <tr><th>Adoption Fee:</th><td>$<?php echo number_format($p_adoption_fee, 2); ?></td></tr>
            </tbody>
        </table>

        <div class="details-section-title">
            <span class="material-icons">description</span> Description
        </div>
        <p><?php echo nl2br(htmlspecialchars($p_description)); ?></p>

        <div class="details-section-title">
            <span class="material-icons">health_and_safety</span> Health Information
        </div>
        <p><?php echo nl2br(htmlspecialchars($p_health_info)); ?></p>

        <div class="details-section-title">
            <span class="material-icons">person</span> Contact Owner
        </div>
        <div class="owner-info-item">
            <span class="material-icons">person</span>
            <span>Name: <a href="owner.php?user_id=<?php echo $p_user_id; ?>"><?php echo htmlspecialchars($p_username); ?></a></span>
        </div>
        <div class="owner-info-item">
            <span class="material-icons">email</span>
            <span>Email: <a href="mailto:<?php echo htmlspecialchars($p_email); ?>"><?php echo htmlspecialchars($p_email); ?></a></span>
        </div>
        <?php if ($p_phone): ?>
        <div class="owner-info-item">
            <span class="material-icons">phone</span>
            <span>Phone: <?php echo htmlspecialchars($p_phone); ?></span>
        </div>
        <?php endif; ?>
        <?php if ($p_location): ?>
        <div class="owner-info-item">
            <span class="material-icons">location_on</span>
            <span>Location: <?php echo htmlspecialchars($p_location); ?></span>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id']) && intval($_SESSION['user_id']) === intval($p_user_id)): ?>
        <div class="mt-3 d-flex gap-2">
            <a href="edit.php?id=<?php echo $p_id; ?>" class="btn-primary-custom">
                <span class="material-icons icon-sm">edit</span> Edit
            </a>
            <button type="button" id="deleteBtn" class="btn btn-danger d-flex align-items-center gap-1">
                <span class="material-icons icon-sm">delete</span> Delete
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><span class="material-icons icon-sm">warning</span> Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">This action cannot be undone.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <span class="material-icons icon-sm">cancel</span> Cancel
                </button>
                <a href="details.php?id=<?php echo $p_id; ?>&action=delete" class="btn btn-danger">
                    <span class="material-icons icon-sm">delete</span> Yes, Delete
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="petModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPetImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
