<?php
$pageTitle = "Browse Pets";
$activePage = "pets";
$basePath = "";
include 'includes/db_connect.inc';
include 'includes/header.inc';
?>

<div class="row g-4">
    <div class="col-md-4">
        <img src="assets/images/banner.jpg" alt="Pets Banner" class="img-fluid rounded w-100">
    </div>
    <div class="col-md-8">
        <h2 class="gradient-heading mb-4">All Available Pets</h2>
        <div class="table-responsive">
            <table class="table table-hover pet-table">
                <thead class="table-light">
                    <tr>
                        <th>NAME</th>
                        <th>SPECIES</th>
                        <th>BREED</th>
                        <th>SIZE</th>
                        <th>FEE ($)</th>
                    </tr>
                </thead>
                <tbody>
<?php
$stmt = mysqli_prepare($conn, "SELECT id, name, species, breed, size, adoption_fee FROM pets ORDER BY name ASC");
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $name, $species, $breed, $size, $adoption_fee);
$pets = [];
while (mysqli_stmt_fetch($stmt)) {
    $pets[] = ['id' => $id, 'name' => $name, 'species' => $species, 'breed' => $breed, 'size' => $size, 'adoption_fee' => $adoption_fee];
}
mysqli_stmt_close($stmt);
foreach ($pets as $pet) {
?>
                    <tr>
                        <td><a href="details.php?id=<?php echo $pet['id']; ?>"><?php echo htmlspecialchars($pet['name']); ?></a></td>
                        <td><?php echo htmlspecialchars($pet['species']); ?></td>
                        <td><?php echo htmlspecialchars($pet['breed'] ?? '—'); ?></td>
                        <td><?php echo htmlspecialchars($pet['size']); ?></td>
                        <td>$<?php echo number_format($pet['adoption_fee'], 2); ?></td>
                    </tr>
<?php
}
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
