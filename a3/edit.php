<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = "Please log in to edit a pet.";
    $_SESSION['flash_type'] = "warning";
    header("Location: login.php");
    exit;
}
$pageTitle = "Edit Pet";
$activePage = "";
$basePath = "";
include 'includes/db_connect.inc';

$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($pet_id === 0) {
    header("Location: pets.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT pet_id, user_id, name, species, breed, age_years, age_months, gender, size, description, health_info, image_path, adoption_fee, status FROM pets WHERE pet_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $pet_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $p_id, $p_user_id, $p_name, $p_species, $p_breed, $p_age_years, $p_age_months, $p_gender, $p_size, $p_description, $p_health_info, $p_image_path, $p_adoption_fee, $p_status);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$found) {
    header("Location: pets.php");
    exit;
}

if (intval($_SESSION['user_id']) !== intval($p_user_id)) {
    $_SESSION['flash_message'] = "You do not have permission to edit this pet.";
    $_SESSION['flash_type'] = "danger";
    header("Location: details.php?id=" . $pet_id);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $species = trim($_POST['species']);
    $breed = trim($_POST['breed']);
    $age_years = intval($_POST['age_years']);
    $age_months = intval($_POST['age_months']);
    $gender = trim($_POST['gender']);
    $size = trim($_POST['size']);
    $adoption_fee = floatval($_POST['adoption_fee']);
    $description = trim($_POST['description']);
    $health_info = trim($_POST['health_info']);
    $status = trim($_POST['status']);
    $new_image_path = $p_image_path;

    if (empty($name) || empty($species) || empty($gender) || empty($size) || empty($description) || empty($status)) {
        $_SESSION['flash_message'] = "Please fill in all required fields.";
        $_SESSION['flash_type'] = "danger";
        header("Location: edit.php?id=" . $pet_id);
        exit;
    }

    if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['petImage']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            if ($p_image_path && file_exists('assets/images/pets/' . $p_image_path)) {
                unlink('assets/images/pets/' . $p_image_path);
            }
            $new_image_path = uniqid('pet_') . '.' . $ext;
            move_uploaded_file($_FILES['petImage']['tmp_name'], 'assets/images/pets/' . $new_image_path);
        }
    }

    $owner_id = intval($_SESSION['user_id']);
    $stmt = mysqli_prepare($conn, "UPDATE pets SET name = ?, species = ?, breed = ?, age_years = ?, age_months = ?, gender = ?, size = ?, description = ?, health_info = ?, image_path = ?, adoption_fee = ?, status = ? WHERE pet_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, 'sssiisssssdsii', $name, $species, $breed, $age_years, $age_months, $gender, $size, $description, $health_info, $new_image_path, $adoption_fee, $status, $pet_id, $owner_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['flash_message'] = "Pet updated successfully!";
    $_SESSION['flash_type'] = "success";
    header("Location: details.php?id=" . $pet_id);
    exit;
}

include 'includes/header.inc';
?>

<h2 class="form-section-title">
    <span class="material-icons">edit</span> Edit Pet: <?php echo htmlspecialchars($p_name); ?>
</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="edit.php?id=<?php echo $p_id; ?>" method="POST" enctype="multipart/form-data">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Pet Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($p_name); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="species" class="form-label">Species <span class="text-danger">*</span></label>
                    <select class="form-select" id="species" name="species" required>
                        <option value="Dog" <?php echo $p_species === 'Dog' ? 'selected' : ''; ?>>Dog</option>
                        <option value="Cat" <?php echo $p_species === 'Cat' ? 'selected' : ''; ?>>Cat</option>
                        <option value="Bird" <?php echo $p_species === 'Bird' ? 'selected' : ''; ?>>Bird</option>
                        <option value="Rabbit" <?php echo $p_species === 'Rabbit' ? 'selected' : ''; ?>>Rabbit</option>
                        <option value="Other" <?php echo $p_species === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="breed" class="form-label">Breed</label>
                    <input type="text" class="form-control" id="breed" name="breed" value="<?php echo htmlspecialchars($p_breed); ?>">
                </div>
                <div class="col-md-3">
                    <label for="age_years" class="form-label">Age (Years)</label>
                    <input type="number" class="form-control" id="age_years" name="age_years" min="0" max="30" value="<?php echo $p_age_years; ?>">
                </div>
                <div class="col-md-3">
                    <label for="age_months" class="form-label">Age (Months)</label>
                    <input type="number" class="form-control" id="age_months" name="age_months" min="0" max="11" value="<?php echo $p_age_months; ?>">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="Male" <?php echo $p_gender === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $p_gender === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Unknown" <?php echo $p_gender === 'Unknown' ? 'selected' : ''; ?>>Unknown</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                    <select class="form-select" id="size" name="size" required>
                        <option value="Small" <?php echo $p_size === 'Small' ? 'selected' : ''; ?>>Small</option>
                        <option value="Medium" <?php echo $p_size === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="Large" <?php echo $p_size === 'Large' ? 'selected' : ''; ?>>Large</option>
                        <option value="Extra Large" <?php echo $p_size === 'Extra Large' ? 'selected' : ''; ?>>Extra Large</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="adoption_fee" class="form-label">Adoption Fee ($) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="adoption_fee" name="adoption_fee" min="0" step="0.01" value="<?php echo number_format($p_adoption_fee, 2); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Available" <?php echo $p_status === 'Available' ? 'selected' : ''; ?>>Available</option>
                    <option value="Pending" <?php echo $p_status === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Adopted" <?php echo $p_status === 'Adopted' ? 'selected' : ''; ?>>Adopted</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($p_description); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="health_info" class="form-label">Health Information</label>
                <textarea class="form-control" id="health_info" name="health_info" rows="3"><?php echo htmlspecialchars($p_health_info); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Current Photo</label>
                <?php if ($p_image_path): ?>
                <div class="mb-2">
                    <img src="assets/images/pets/<?php echo htmlspecialchars($p_image_path); ?>" alt="Current photo" class="img-thumbnail current-photo-thumb">
                </div>
                <?php endif; ?>
                <label for="petImage" class="form-label">Upload New Photo (leave blank to keep current)</label>
                <input type="file" class="form-control" id="petImage" name="petImage" accept="image/*">
                <div class="image-preview-box">
                    <div id="imageValidationMsg"></div>
                    <img id="imagePreview" src="" alt="Preview">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-primary-custom">
                    <span class="material-icons icon-sm">save</span> Save Changes
                </button>
                <a href="details.php?id=<?php echo $p_id; ?>" class="btn-secondary-custom">
                    <span class="material-icons icon-sm">cancel</span> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
