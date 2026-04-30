<?php
include 'includes/db_connect.inc';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add.php');
    exit;
}

$name        = trim($_POST['name'] ?? '');
$species     = trim($_POST['species'] ?? '');
$breed       = trim($_POST['breed'] ?? '');
$gender      = trim($_POST['gender'] ?? '');
$size        = trim($_POST['size'] ?? '');
$age_years   = intval($_POST['age_years'] ?? 0);
$age_months  = intval($_POST['age_months'] ?? 0);
$adoption_fee = floatval($_POST['adoption_fee'] ?? 0);
$description = trim($_POST['description'] ?? '');
$health_info = trim($_POST['health_info'] ?? '');
$status      = trim($_POST['status'] ?? '');

$required_fields = [
    'name'         => $name,
    'species'      => $species,
    'gender'       => $gender,
    'size'         => $size,
    'adoption_fee' => $_POST['adoption_fee'] ?? '',
    'description'  => $description,
    'status'       => $status,
];

foreach ($required_fields as $field => $value) {
    if ($value === '' || $value === null) {
        header('Location: add.php?error=' . urlencode('Please fill in all required fields.'));
        exit;
    }
}

$valid_species = ['Dog', 'Cat', 'Bird', 'Rabbit', 'Other'];
$valid_gender  = ['Male', 'Female'];
$valid_size    = ['Small', 'Medium', 'Large', 'Extra Large'];
$valid_status  = ['available', 'pending', 'adopted'];

if (!in_array($species, $valid_species) || !in_array($gender, $valid_gender) || !in_array($size, $valid_size) || !in_array($status, $valid_status)) {
    header('Location: add.php?error=' . urlencode('Invalid field values submitted.'));
    exit;
}

$image_filename = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $original_name = $_FILES['image']['name'];
    $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_extensions)) {
        header('Location: add.php?error=' . urlencode('Invalid image file type. Allowed: jpg, jpeg, png, gif, webp.'));
        exit;
    }

    $image_filename = uniqid() . '_' . time() . '.' . $ext;
    $upload_dir = __DIR__ . '/assets/images/pets/';
    $upload_path = $upload_dir . $image_filename;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
        header('Location: add.php?error=' . urlencode('Failed to upload image. Please try again.'));
        exit;
    }
}

$stmt = mysqli_prepare($conn, "INSERT INTO pets (name, species, breed, gender, size, age_years, age_months, adoption_fee, description, health_info, status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$breed_val       = ($breed !== '') ? $breed : null;
$health_info_val = ($health_info !== '') ? $health_info : null;

mysqli_stmt_bind_param(
    $stmt,
    'sssssiidssss',
    $name,
    $species,
    $breed_val,
    $gender,
    $size,
    $age_years,
    $age_months,
    $adoption_fee,
    $description,
    $health_info_val,
    $status,
    $image_filename
);

if (mysqli_stmt_execute($stmt)) {
    $new_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    header('Location: details.php?id=' . $new_id);
    exit;
} else {
    mysqli_stmt_close($stmt);
    header('Location: add.php?error=' . urlencode('Database error. Could not add pet. Please try again.'));
    exit;
}
?>
