<?php
session_start();
$pageTitle = "Search";
$activePage = "search";
$basePath = "";
include 'includes/db_connect.inc';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$searched = isset($_GET['q']);
$results = [];

if ($searched && $q !== '') {
    $like = '%' . $q . '%';
    $stmt = mysqli_prepare($conn, "SELECT pet_id, name, adoption_fee, image_path FROM pets WHERE name LIKE ? OR description LIKE ?");
    mysqli_stmt_bind_param($stmt, 'ss', $like, $like);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $r_pet_id, $r_name, $r_adoption_fee, $r_image_path);
    while (mysqli_stmt_fetch($stmt)) {
        $results[] = [
            'pet_id'       => $r_pet_id,
            'name'         => $r_name,
            'adoption_fee' => $r_adoption_fee,
            'image_path'   => $r_image_path
        ];
    }
    mysqli_stmt_close($stmt);
}

include 'includes/header.inc';
?>

<div class="search-header">
    <h2>Search Pets</h2>
    <form method="GET" action="search.php" class="row g-2">
        <div class="col-12 col-md-9">
            <input type="text" name="q" class="form-control" placeholder="Search by name or description..." value="<?php echo htmlspecialchars($q); ?>">
        </div>
        <div class="col-12 col-md-3">
            <button type="submit" class="btn-primary-custom w-100 justify-content-center">
                <span class="material-icons icon-sm">search</span> Search
            </button>
        </div>
    </form>
</div>

<?php if ($searched): ?>
<p class="text-muted mb-3"><?php echo count($results); ?> result(s) found.</p>
<?php if (count($results) > 0): ?>
<div class="row g-3">
<?php foreach ($results as $pet): ?>
    <div class="col-6 col-md-3">
        <div class="pet-card">
            <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>">
            <div class="card-body">
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="pet-name-link"><?php echo htmlspecialchars($pet['name']); ?></a>
                <span class="pet-price">$<?php echo number_format($pet['adoption_fee'], 2); ?></span>
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="btn-primary-custom btn-sm w-100 justify-content-center mt-1">
                    <span class="material-icons icon-sm">pets</span> View Details
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php else: ?>
<div class="alert alert-info">No pets found matching your search. Try a different keyword.</div>
<?php endif; ?>
<?php endif; ?>

<?php include 'includes/footer.inc'; ?>
