<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama_item'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$durasi = $_POST['durasi_posting'];

$conn->query("UPDATE items SET 
    nama_item = '$nama',
    harga = '$harga',
    stok = '$stok',
    durasi_posting = '$durasi'
    WHERE id = $id");

header("Location: index.php");
?>