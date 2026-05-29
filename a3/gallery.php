<?php
session_start();
$pageTitle = "Gallery";
$activePage = "gallery";
$basePath = "";
include 'includes/db_connect.inc';
include 'includes/header.inc';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="gallery-heading">Pet Gallery</h2>
    <div>
        <span class="filter-label">Filter by Status:</span>
        <select id="statusFilter" class="form-select form-select-sm gallery-filter-select">
            <option value="all">Show All</option>
            <option value="Available">Available</option>
            <option value="Pending">Pending</option>
            <option value="Adopted">Adopted</option>
        </select>
    </div>
</div>

<div class="row g-3">
<?php
$sql = "SELECT pet_id, name, species, adoption_fee, status, image_path FROM pets ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
while ($pet = mysqli_fetch_assoc($result)) {
    $statusClass = 'badge-status-' . strtolower($pet['status']);
?>
    <div class="col-6 col-md-3">
        <div class="gallery-item" data-status="<?php echo htmlspecialchars($pet['status']); ?>">
            <div class="pet-card">
                <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>"
                     alt="<?php echo htmlspecialchars($pet['name']); ?>"
                     class="gallery-img"
                     data-img="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>"
                     data-name="<?php echo htmlspecialchars($pet['name']); ?>">
                <div class="card-body">
                    <p class="pet-name mb-1"><?php echo htmlspecialchars($pet['name']); ?></p>
                    <div class="d-flex gap-1 mb-1">
                        <span class="badge-species"><?php echo htmlspecialchars($pet['species']); ?></span>
                        <span class="<?php echo $statusClass; ?>"><?php echo htmlspecialchars($pet['status']); ?></span>
                    </div>
                    <p class="pet-fee mb-1">$<?php echo number_format($pet['adoption_fee'], 2); ?></p>
                    <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="btn-primary-custom btn-sm w-100 justify-content-center">
                        <span class="material-icons icon-sm">pets</span> View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>

<div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="petModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalPetImage" src="" alt="Pet photo" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
