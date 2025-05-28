<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM items WHERE id = $id")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-warning text-dark">
      <h4 class="mb-0">Edit Item: <?= $data['nama_item'] ?></h4>
    </div>
    <div class="card-body">
      <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="mb-3">
          <label class="form-label">item name</label>
          <input type="text" name="nama_item" class="form-control" value="<?= $data['nama_item'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">price</label>
          <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">take down in:</label>
          <input type="number" name="durasi_posting" class="form-control" value="<?= $data['durasi_posting'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">save </button>
        <a href="index.php" class="btn btn-secondary">cancel</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>