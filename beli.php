<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  die("Anda harus login terlebih dahulu.");
}

$user_id = $_SESSION['user_id'];
$item_id = $_POST['item_id'];
$jumlah = (int) $_POST['jumlah'];

// Ambil data item
$sql = "SELECT stok, harga FROM items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Item tidak ditemukan.");
}

$item = $result->fetch_assoc();

if ($jumlah > $item['stok']) {
  die("Stok tidak mencukupi.");
}

// Hitung total dan kurangi stok
$total = $item['harga'] * $jumlah;

// Simpan order
$stmt = $conn->prepare("INSERT INTO orders (user_id, item_id, jumlah, total) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $user_id, $item_id, $jumlah, $total);
$stmt->execute();

// Update stok
$stmt = $conn->prepare("UPDATE items SET stok = stok - ? WHERE id = ?");
$stmt->bind_param("ii", $jumlah, $item_id);
$stmt->execute();

header("Location: index.php?success=1");
exit;
?>

