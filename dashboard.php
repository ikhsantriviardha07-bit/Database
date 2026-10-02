<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Inventaris</title>
    </head>
    <body>
        <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
        <p>Role Anda: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>

        <hr>
        <ul>
            <h1><a href="update_stock.php">Update Stock Alat Lab></a></h1>
            <p>Role Anda: <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>

            <hr>
            <ul>
                <li><a href="update_stock.php">Update Stock Alat Lab</a></li>
                <li><a href="api_alat.php" target="_blank">Lihat Output API <JSON></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
    </body>
</html>        