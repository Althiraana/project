<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$user = $result->fetch_assoc();
?>

<h2>Profil Saya</h2>
<p><strong>Nama:</strong> <?= htmlspecialchars($user['nama']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['username']) ?></p>
<p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
<a href="logout.php">Logout</a>
