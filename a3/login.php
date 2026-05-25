<?php
session_start();
$pageTitle = "Login";
$activePage = "";
$basePath = "";
include 'includes/db_connect.inc';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_input = trim($_POST['login_input']);
    $password = trim($_POST['password']);

    $stmt = mysqli_prepare($conn, "SELECT user_id, username, password FROM users WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $login_input, $login_input);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password);
    $found = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($found && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['flash_message'] = "Welcome back, " . $username . "!";
        $_SESSION['flash_type'] = "success";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['flash_message'] = "Invalid username/email or password.";
        $_SESSION['flash_type'] = "danger";
        header("Location: login.php");
        exit;
    }
}

include 'includes/header.inc';
?>

<div class="auth-card">
    <h2 class="auth-heading">Login to PetConnect</h2>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="login_input" class="form-label">Username or Email</label>
            <input type="text" class="form-control" id="login_input" name="login_input" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Log In</button>
        <div class="auth-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </form>
</div>

<?php include 'includes/footer.inc'; ?>
