<?php
session_start();
$pageTitle = "Search";
$activePage = "search";
$basePath = "";
include 'includes/db_connect.inc';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$species = isset($_GET['species']) ? trim($_GET['species']) : '';
$gender = isset($_GET['gender']) ? trim($_GET['gender']) : '';
$size = isset($_GET['size']) ? trim($_GET['size']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$max_fee = isset($_GET['max_fee']) && $_GET['max_fee'] !== '' ? floatval($_GET['max_fee']) : null;

$searched = ($keyword !== '' || $species !== '' || $gender !== '' || $size !== '' || $status !== '' || $max_fee !== null);

$results = [];

if ($searched) {
    $where = [];
    $types = '';
    $params = [];

    if ($keyword !== '') {
        $where[] = "(p.name LIKE ? OR p.breed LIKE ? OR p.description LIKE ?)";
        $like = '%' . $keyword . '%';
        $types .= 'sss';
        $params[] = $like;
        $params[] = $like;
        $params[] = $like;
    }
    if ($species !== '') {
        $where[] = "p.species = ?";
        $types .= 's';
        $params[] = $species;
    }
    if ($gender !== '') {
        $where[] = "p.gender = ?";
        $types .= 's';
        $params[] = $gender;
    }
    if ($size !== '') {
        $where[] = "p.size = ?";
        $types .= 's';
        $params[] = $size;
    }
    if ($status !== '') {
        $where[] = "p.status = ?";
        $types .= 's';
        $params[] = $status;
    }
    if ($max_fee !== null) {
        $where[] = "p.adoption_fee <= ?";
        $types .= 'd';
        $params[] = $max_fee;
    }

    $sql = "SELECT p.pet_id, p.name, p.species, p.adoption_fee, p.status, p.image_path, u.username, u.user_id FROM pets p JOIN users u ON p.user_id = u.user_id";
    if (count($where) > 0) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY p.name ASC";

    if (count($params) > 0) {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $r_pet_id, $r_name, $r_species, $r_adoption_fee, $r_status, $r_image_path, $r_username, $r_user_id);
        while (mysqli_stmt_fetch($stmt)) {
            $results[] = [
                'pet_id' => $r_pet_id,
                'name' => $r_name,
                'species' => $r_species,
                'adoption_fee' => $r_adoption_fee,
                'status' => $r_status,
                'image_path' => $r_image_path,
                'username' => $r_username,
                'user_id' => $r_user_id
            ];
        }
        mysqli_stmt_close($stmt);
    } else {
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $results[] = $row;
        }
    }
}

include 'includes/header.inc';
?>

<div class="search-header">
    <h2>Search Pets</h2>
    <form method="GET" action="search.php" class="row g-2">
        <div class="col-12 col-md-6">
            <input type="text" name="keyword" class="form-control" placeholder="Search by name, breed, or description..." value="<?php echo htmlspecialchars($keyword); ?>">
        </div>
        <div class="col-6 col-md-3">
            <select name="species" class="form-select">
                <option value="">Any Species</option>
                <option value="Dog" <?php echo $species === 'Dog' ? 'selected' : ''; ?>>Dog</option>
                <option value="Cat" <?php echo $species === 'Cat' ? 'selected' : ''; ?>>Cat</option>
                <option value="Bird" <?php echo $species === 'Bird' ? 'selected' : ''; ?>>Bird</option>
                <option value="Rabbit" <?php echo $species === 'Rabbit' ? 'selected' : ''; ?>>Rabbit</option>
                <option value="Other" <?php echo $species === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <select name="gender" class="form-select">
                <option value="">Any Gender</option>
                <option value="Male" <?php echo $gender === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $gender === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Unknown" <?php echo $gender === 'Unknown' ? 'selected' : ''; ?>>Unknown</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <select name="size" class="form-select">
                <option value="">Any Size</option>
                <option value="Small" <?php echo $size === 'Small' ? 'selected' : ''; ?>>Small</option>
                <option value="Medium" <?php echo $size === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                <option value="Large" <?php echo $size === 'Large' ? 'selected' : ''; ?>>Large</option>
                <option value="Extra Large" <?php echo $size === 'Extra Large' ? 'selected' : ''; ?>>Extra Large</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <select name="status" class="form-select">
                <option value="">Any Status</option>
                <option value="Available" <?php echo $status === 'Available' ? 'selected' : ''; ?>>Available</option>
                <option value="Pending" <?php echo $status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="Adopted" <?php echo $status === 'Adopted' ? 'selected' : ''; ?>>Adopted</option>
            </select>
        </div>
        <div class="col-6 col-md-3">
            <input type="number" name="max_fee" class="form-control" placeholder="Max fee ($)" min="0" step="0.01" value="<?php echo $max_fee !== null ? htmlspecialchars($max_fee) : ''; ?>">
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
<?php foreach ($results as $pet):
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
                <a href="owner.php?user_id=<?php echo $pet['user_id']; ?>" class="owner-small"><?php echo htmlspecialchars($pet['username']); ?></a>
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="btn-primary-custom btn-sm w-100 justify-content-center mt-1">
                    <span class="material-icons icon-sm">pets</span> View Details
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php else: ?>
<div class="alert alert-info">No pets found matching your search criteria. Try broadening your search.</div>
<?php endif; ?>
<?php endif; ?>

<?php include 'includes/footer.inc'; ?>
