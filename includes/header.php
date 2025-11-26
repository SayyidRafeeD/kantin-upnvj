<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'DIRKA UPNVJ'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);

    if ($currentPage == 'store.php') {
        echo '<link rel="stylesheet" href="assets/css/detail.css">';
    } elseif ($currentPage == 'login.php' || $currentPage == 'register.php') {
        echo '<link rel="stylesheet" href="assets/css/auth.css">';
    } elseif ($currentPage == 'my_reviews.php') {
        echo '<link rel="stylesheet" href="assets/css/my_reviews.css">';
    }
    ?>
</head>
<body>

<?php if (!in_array($currentPage, ['login.php', 'register.php'])): ?>
    <header>
        <nav class="navbar">
            <a href="index.php" class="nav-logo">
                <img src="assets/images/logo.png" alt="Logo UPNVJ">
                <span>DIRKA UPNVJ</span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="my_reviews.php">Ulasan Saya</a></li>
                    <li><a href="logout.php" style="color: #d9534f;">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
            <div class="burger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
    </header>
<?php endif; ?>

<main class="container">