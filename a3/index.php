<?php
session_start();
$pageTitle = "Home";
$activePage = "home";
$basePath = "";
include 'includes/db_connect.inc';
include 'includes/header.inc';
?>

<?php
$sql = "SELECT pet_id, name, image_path FROM pets ORDER BY created_at DESC LIMIT 4";
$result = mysqli_query($conn, $sql);
$slides = [];
while ($row = mysqli_fetch_assoc($result)) {
    $slides[] = $row;
}
?>

<div class="carousel-breakout">
<div id="petCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php foreach ($slides as $index => $slide): ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
            <img src="assets/images/pets/<?php echo htmlspecialchars($slide['image_path']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($slide['name']); ?>">
            <div class="carousel-caption-bar">
                <h5><?php echo htmlspecialchars($slide['name']); ?></h5>
                <a href="details.php?id=<?php echo $slide['pet_id']; ?>" class="btn">
                    <span class="material-icons icon-sm">pets</span> View Details
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
</div>

<h2 class="home-section-title">
    <span class="material-icons">favorite</span> Recently Added Pets
</h2>

<div class="row g-3">
<?php
$sql = "SELECT p.pet_id, p.name, p.adoption_fee, p.image_path, u.username, u.user_id FROM pets p JOIN users u ON p.user_id = u.user_id ORDER BY p.created_at DESC LIMIT 4";
$result = mysqli_query($conn, $sql);
while ($pet = mysqli_fetch_assoc($result)) {
?>
    <div class="col-6 col-md-3">
        <div class="pet-card">
            <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>">
            <div class="card-body">
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="pet-name-link"><?php echo htmlspecialchars($pet['name']); ?></a>
                <span class="pet-price">$<?php echo number_format($pet['adoption_fee'], 2); ?></span>
                <a href="owner.php?user_id=<?php echo $pet['user_id']; ?>" class="owner-small"><?php echo htmlspecialchars($pet['username']); ?></a>
                <a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="btn-primary-custom btn-sm w-100 justify-content-center">
                    <span class="material-icons icon-sm">pets</span> View Details
                </a>
            </div>
        </div>
    </div>
<?php } ?>
</div>

<?php include 'includes/footer.inc'; ?>
