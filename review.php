<?php
include 'koneksi.php';

$item_id = intval($_GET['id'] ?? 0);

// Fetch item
$item = null;
if ($item_id) {
  $item_query = "SELECT * FROM item WHERE id = $item_id";
  $item_result = $conn->query($item_query);
  $item = $item_result->fetch_assoc();
}

// Handle submit review
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $rating = intval($_POST['rating']);
  $comment = $conn->real_escape_string($_POST['comment']);
  
  $conn->query("INSERT INTO reviews (item_id, rating, comment) VALUES ($item_id, $rating, '$comment')");
  header("Location: review.php?id=$item_id");
  exit;
}

// Fetch reviews
$reviews_query = "SELECT * FROM reviews WHERE item_id = $item_id ORDER BY created_at DESC";
$reviews = $conn->query($reviews_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Review Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .rating {
      color: #ffc107;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">
  <a href="index.php" class="btn btn-secondary mb-4">← Kembali</a>

  <?php if ($item): ?>
    <h2>Review untuk: <?= htmlspecialchars($item['nama_item']) ?></h2>

    <form method="post" class="mb-5">
      <div class="mb-3">
        <label for="rating" class="form-label">Rating (1-5)</label>
        <select name="rating" id="rating" class="form-select" required>
          <option value="">Pilih Rating</option>
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <option value="<?= $i ?>"><?= $i ?> Bintang</option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="comment" class="form-label">Komentar</label>
        <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Kirim Review</button>
    </form>

    <h4>Semua Review</h4>
    <?php if ($reviews->num_rows > 0): ?>
      <?php while ($review = $reviews->fetch_assoc()): ?>
        <div class="card mb-3">
          <div class="card-body">
            <div class="mb-2">
              <?php 
              for ($i = 1; $i <= 5; $i++) {
                echo $i <= $review['rating'] ? '<span class="rating">&#9733;</span>' : '<span class="rating" style="color:#e4e5e9;">&#9733;</span>';
              }
              ?>
            </div>
            <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
            <small class="text-muted"><?= $review['created_at'] ?></small>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Belum ada review.</p>
    <?php endif; ?>

  <?php else: ?>
    <p>Item tidak ditemukan.</p>
  <?php endif; ?>
</div>
</body>
</html>