<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = "Please log in to add a pet.";
    $_SESSION['flash_type'] = "warning";
    header("Location: login.php");
    exit;
}
$pageTitle = "Add Pet";
$activePage = "add";
$basePath = "";
include 'includes/db_connect.inc';

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
    $user_id = intval($_SESSION['user_id']);
    $image_path = null;

    if (empty($name) || empty($species) || empty($gender) || empty($size) || empty($description) || empty($status)) {
        $_SESSION['flash_message'] = "Please fill in all required fields.";
        $_SESSION['flash_type'] = "danger";
        header("Location: add.php");
        exit;
    }

    if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['petImage']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $image_path = uniqid('pet_') . '.' . $ext;
            move_uploaded_file($_FILES['petImage']['tmp_name'], 'assets/images/pets/' . $image_path);
        }
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO pets (user_id, name, species, breed, age_years, age_months, gender, size, description, health_info, image_path, adoption_fee, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isssiisssssds', $user_id, $name, $species, $breed, $age_years, $age_months, $gender, $size, $description, $health_info, $image_path, $adoption_fee, $status);
    mysqli_stmt_execute($stmt);
    $new_pet_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    $_SESSION['flash_message'] = "Pet added successfully!";
    $_SESSION['flash_type'] = "success";
    header("Location: details.php?id=" . $new_pet_id);
    exit;
}

include 'includes/header.inc';
?>

<h2 class="form-section-title">
    <span class="material-icons">add_circle</span> Add a New Pet for Adoption
</h2>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="add.php" method="POST" enctype="multipart/form-data">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Pet Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Buddy" required>
                </div>
                <div class="col-md-6">
                    <label for="species" class="form-label">Species <span class="text-danger">*</span></label>
                    <select class="form-select" id="species" name="species" required>
                        <option value="" disabled selected>Select species</option>
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Bird">Bird</option>
                        <option value="Rabbit">Rabbit</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="breed" class="form-label">Breed</label>
                    <input type="text" class="form-control" id="breed" name="breed" placeholder="e.g. Golden Retriever">
                </div>
                <div class="col-md-3">
                    <label for="age_years" class="form-label">Age (Years)</label>
                    <input type="number" class="form-control" id="age_years" name="age_years" placeholder="0" min="0" max="30" value="0">
                </div>
                <div class="col-md-3">
                    <label for="age_months" class="form-label">Age (Months)</label>
                    <input type="number" class="form-control" id="age_months" name="age_months" placeholder="0" min="0" max="11" value="0">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                    <select class="form-select" id="size" name="size" required>
                        <option value="" disabled selected>Select size</option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="Extra Large">Extra Large</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="adoption_fee" class="form-label">Adoption Fee ($) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="adoption_fee" name="adoption_fee" placeholder="e.g. 150.00" min="0" step="0.01" value="0" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="status" name="status" required>
                    <option value="" disabled selected>Select status</option>
                    <option value="Available">Available</option>
                    <option value="Pending">Pending</option>
                    <option value="Adopted">Adopted</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the pet's personality, habits, and what makes them special..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="health_info" class="form-label">Health Information</label>
                <textarea class="form-control" id="health_info" name="health_info" rows="3" placeholder="Vaccination status, medical history, special needs..."></textarea>
            </div>

            <div class="mb-4">
                <label for="petImage" class="form-label">Pet Photo</label>
                <input type="file" class="form-control" id="petImage" name="petImage" accept="image/*">
                <div class="image-preview-box">
                    <div id="imageValidationMsg"></div>
                    <img id="imagePreview" src="" alt="Preview">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-primary-custom">
                    <span class="material-icons icon-sm">save</span> Add Pet
                </button>
                <a href="index.php" class="btn-secondary-custom">
                    <span class="material-icons icon-sm">cancel</span> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>
