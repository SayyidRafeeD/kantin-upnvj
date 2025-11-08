<?php

$full_name = $_SESSION['full_name'] ?? 'Pengguna';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Kantin UPNVJ'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <header>
        <nav class="navbar">
            <a href="index.php" class="nav-logo">KantinKampus</a>
            <ul class="nav-links">
                <li><span class="user-name">Hi, <?php echo htmlspecialchars(explode(' ', $full_name)[0]);?>!</span></li>
                <li>
                    <form action="logout.php" method="POST" style="display: inline;">
                        <button type="submit" class="logout-button">Logout</button>
                    </form>
                </li>
            </ul>
            <div class="burger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
    </header>
    
    <main class="container">