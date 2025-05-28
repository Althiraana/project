<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>add item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">add item:</h4>
    </div>
    <div class="card-body">
      <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">item name:</label>
          <input type="text" name="nama_item" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">price</label>
          <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">take down in:</label>
          <input type="number" name="durasi_posting" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Foto Item</label>
          <input type="file" name="foto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">submit</button>
        <a href="index.php" class="btn btn-secondary">back</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>