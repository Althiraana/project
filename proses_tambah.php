<?php
include 'koneksi.php';

// Dummy user dan kategori 
$user_id = 1;
$kategori_id = 1;

$nama = $_POST['nama_item'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$durasi = $_POST['durasi_posting'];

$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
$folder = 'uploads/' . $foto;

move_uploaded_file($tmp, $folder);

$conn->query("INSERT INTO items (user_id, category_id, nama_item, harga, stok, durasi_posting) 
              VALUES ('$user_id', '$kategori_id', '$nama', '$harga', '$stok', '$durasi')");

$item_id = $conn->insert_id;

$conn->query("INSERT INTO item_photos (item_id, path_foto) VALUES ('$item_id', '$foto')");

header("Location: index.php");
?>