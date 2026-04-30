<?php
$pageTitle = "Gallery";
$activePage = "gallery";
$basePath = "";
include 'includes/db_connect.inc';
include 'includes/header.inc';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="section-heading gallery-title mb-0">Pet Gallery</h2>
    <div>
        <span class="filter-label">
            <span class="material-icons icon-xs">filter_list</span>
            Filter by Status:
        </span>
        <select id="statusFilter" class="form-select form-select-sm" style="width:auto;display:inline-block;">
            <option value="all">Show All</option>
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="adopted">Adopted</option>
        </select>
    </div>
</div>

<div class="row g-3">
<?php
$stmt = mysqli_prepare($conn, "SELECT id, name, species, adoption_fee, status, image FROM pets ORDER BY created_at DESC");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $name, $species, $adoption_fee, $status, $image);
$pets = [];
while (mysqli_stmt_fetch($stmt)) {
    $pets[] = ['id' => $id, 'name' => $name, 'species' => $species, 'adoption_fee' => $adoption_fee, 'status' => $status, 'image' => $image];
}
mysqli_stmt_close($stmt);
foreach ($pets as $pet) {
    $status = strtolower($pet['status']);
?>
    <div class="col-6 col-md-3">
        <div class="gallery-item" data-status="<?php echo htmlspecialchars($status); ?>" data-img="assets/images/pets/<?php echo htmlspecialchars($pet['image']); ?>" data-name="<?php echo htmlspecialchars($pet['name']); ?>">
            <img
                src="assets/images/pets/<?php echo htmlspecialchars($pet['image']); ?>"
                alt="<?php echo htmlspecialchars($pet['name']); ?>"
                class="gallery-img rounded"
            >
            <p class="fw-bold mb-1 mt-2"><?php echo htmlspecialchars($pet['name']); ?></p>
            <div class="mb-1">
                <span class="badge badge-species me-1"><?php echo htmlspecialchars($pet['species']); ?></span>
                <span class="badge badge-<?php echo htmlspecialchars($status); ?>"><?php echo ucfirst($status); ?></span>
            </div>
            <p class="pet-price mb-0">$<?php echo number_format($pet['adoption_fee'], 2); ?></p>
        </div>
    </div>
<?php
}
?>
</div>

<div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
