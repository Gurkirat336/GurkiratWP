<?php
$pageTitle = "Home";
$activePage = "home";
$basePath = "";
include 'includes/db_connect.inc';
include 'includes/header.inc';
?>

<div id="petCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner rounded">
        <div class="carousel-item active">
            <img src="assets/images/pets/buddy.jpg" class="d-block w-100" alt="Buddy">
            <div class="carousel-caption d-none d-md-block">
                <h5>Buddy</h5>
                <p>Golden Retriever &mdash; Available for adoption</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/pets/whiskers.jpg" class="d-block w-100" alt="Whiskers">
            <div class="carousel-caption d-none d-md-block">
                <h5>Whiskers</h5>
                <p>Tabby Cat &mdash; Available for adoption</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/pets/max.jpg" class="d-block w-100" alt="Max">
            <div class="carousel-caption d-none d-md-block">
                <h5>Max</h5>
                <p>Labrador Mix &mdash; Available for adoption</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="assets/images/pets/charlie.jpg" class="d-block w-100" alt="Charlie">
            <div class="carousel-caption d-none d-md-block">
                <h5>Charlie</h5>
                <p>Cockatiel &mdash; Available for adoption</p>
            </div>
        </div>
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

<h2 class="home-section-title">
    <span class="material-icons">favorite</span> Recently Added Pets
</h2>

<div class="row g-3">
<?php
$stmt = mysqli_prepare($conn, "SELECT id, name, species, adoption_fee, image FROM pets ORDER BY created_at DESC LIMIT 4");
mysqli_execute($stmt);
$result = mysqli_get_result($stmt);
while ($pet = mysqli_fetch_assoc($result)) {
?>
    <div class="col-6 col-md-3">
        <div class="pet-card">
            <a href="details.php?id=<?php echo $pet['id']; ?>">
                <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['name']); ?>" class="rounded">
            </a>
            <a href="details.php?id=<?php echo $pet['id']; ?>" class="pet-name-link"><?php echo htmlspecialchars($pet['name']); ?></a>
            <span class="pet-price">$<?php echo number_format($pet['adoption_fee'], 2); ?></span>
        </div>
    </div>
<?php
}
mysqli_stmt_close($stmt);
?>
</div>

<?php include 'includes/footer.inc'; ?>
