<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetConnect - <?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $basePath; ?>assets/css/styles.css" rel="stylesheet">
</head>
<body>
<header>
<?php include $basePath . 'includes/nav.inc'; ?>
</header>
<?php
if (isset($_SESSION['flash_message'])) {
    $flash_type = isset($_SESSION['flash_type']) ? $_SESSION['flash_type'] : 'success';
    echo '<div class="container mt-3"><div class="alert alert-' . $flash_type . ' alert-dismissible fade show" role="alert">';
    echo htmlspecialchars($_SESSION['flash_message']);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div></div>';
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}
?>
<main class="container my-4">
