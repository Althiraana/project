<?php 
session_start(); 
include 'koneksi.php'; 

$query = "SELECT i.*, p.path_foto, c.nama_kategori FROM items i LEFT JOIN item_photos p ON i.id = p.item_id LEFT JOIN categories c ON i.category_id = c.id";
$result = $conn->query($query); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Item List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">
  <img src="cart-removebg-preview.png" alt="Logo" height="40">
</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="visually-hidden">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])) { ?>
          <li class="nav-item">
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>

  <div class="container py-4">
    <h2 class="mb-4">Item List</h2>
    <a href="tambah.php" class="btn btn-primary mb-4">+ Add Item</a>
    <div class="row g-4">
      <?php while ($row = $result->fetch_assoc()): 
        $waktu_posting = strtotime($row['waktu_posting']); 
        $durasi = (int)$row['durasi_posting']; 
        $expire = $waktu_posting + ($durasi * 60); 
        $sisa = $expire - time(); 
        if ($sisa <= 0) continue; // Skip expired items
      ?>
        <div class="col-md-3">
          <div class="card card-product h-100">
            <img src="uploads/<?= htmlspecialchars($row['path_foto']) ?>" class="card-img-top product-img" alt="Product Image">
            <div class="card-body">
              <div class="product-title mb-1"><?= htmlspecialchars($row['nama_item']) ?></div>
              <div class="mb-1">Price: <strong>Rp <?= number_format($row['harga'], 0, ',', '.') ?></strong></div>
              <div class="mb-1">Stock: <?= $row['stok'] ?></div>
              <div class="mb-1">Available: <span class="countdown" data-time="<?= $sisa ?>"></span></div>
              <div class="d-flex gap-2 mt-2">
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning w-100">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger w-100" onclick="return confirm('Delete this item?')">Delete</a>
              </div>
              <?php if (isset($_SESSION['user_id'])): ?>
                <form action="beli.php" method="POST" class="mt-2">
                  <input type="hidden" name="item_id" value="<?= $row['id'] ?>">
                  <input type="number" name="jumlah" min="1" max="<?= $row['stok'] ?>" value="1" class="form-control mb-2" required>
                  <button type="submit" class="btn btn-sm btn-success w-100">Buy</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script>
    // Countdown script
    document.querySelectorAll('.countdown').forEach(el => {
      const secondsLeft = parseInt(el.getAttribute('data-time'));
      const targetTime = Date.now() + (secondsLeft * 1000);

      function updateCountdown() {
        const now = Date.now();
        const diff = Math.max(0, Math.floor((targetTime - now) / 1000));
        const minutes = Math.floor(diff / 60);
        const seconds = diff % 60;
        el.textContent = `${minutes}m ${seconds}s`;

        if (diff > 0) {
          requestAnimationFrame(updateCountdown);
        } else {
          el.textContent = 'Expired';
          el.closest('.col-md-3')?.remove();
        }
      }

      updateCountdown();
    });
  </script>
</body>
</html>
