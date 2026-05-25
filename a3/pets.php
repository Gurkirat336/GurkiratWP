<?php
session_start();
$pageTitle = "Browse Pets";
$activePage = "pets";
$basePath = "";
include 'includes/db_connect.inc';
include 'includes/header.inc';
?>

<h2 class="page-heading">All Available Pets</h2>

<div class="row g-4 align-items-start">
    <div class="col-12 col-md-4">
        <img src="assets/images/banner.jpg" alt="Pets waiting for adoption" class="banner-img">
    </div>
    <div class="col-12 col-md-8">
        <div class="table-responsive">
            <table class="table table-bordered pets-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Species</th>
                        <th>Breed</th>
                        <th>Size</th>
                        <th>Fee ($)</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT p.pet_id, p.name, p.species, p.breed, p.size, p.adoption_fee, p.user_id, u.username FROM pets p JOIN users u ON p.user_id = u.user_id ORDER BY p.name ASC";
                $result = mysqli_query($conn, $sql);
                while ($pet = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><a href="details.php?id=<?php echo $pet['pet_id']; ?>" class="pet-link"><?php echo htmlspecialchars($pet['name']); ?></a></td>
                        <td><?php echo htmlspecialchars($pet['species']); ?></td>
                        <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                        <td><?php echo htmlspecialchars($pet['size']); ?></td>
                        <td><?php echo number_format($pet['adoption_fee'], 2); ?></td>
                        <td><a href="owner.php?user_id=<?php echo $pet['user_id']; ?>" class="pet-link"><span class="material-icons icon-sm">person</span> <?php echo htmlspecialchars($pet['username']); ?></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
