<?php
session_start();
$pageTitle = "Register";
$activePage = "";
$basePath = "";
include 'includes/db_connect.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['flash_message'] = "Username, email, and password are required.";
        $_SESSION['flash_type'] = "danger";
        header("Location: register.php");
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $existing_id);
    $exists = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($exists) {
        $_SESSION['flash_message'] = "Username or email already in use.";
        $_SESSION['flash_type'] = "danger";
        header("Location: register.php");
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, phone, location) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssss', $username, $email, $hashed, $phone, $location);
    mysqli_stmt_execute($stmt);
    $new_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    $_SESSION['user_id'] = $new_id;
    $_SESSION['username'] = $username;
    $_SESSION['flash_message'] = "Welcome to PetConnect, " . $username . "!";
    $_SESSION['flash_type'] = "success";
    header("Location: index.php");
    exit;
}

include 'includes/header.inc';
?>

<div class="auth-card">
    <h2 class="auth-heading">Register for PetConnect</h2>
    <form method="POST" action="register.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone (Optional)</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location (Optional)</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="e.g., Melbourne, VIC">
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
        <div class="auth-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </form>
</div>

<?php include 'includes/footer.inc'; ?>
