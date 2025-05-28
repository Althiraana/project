<?php 
$email = ''; 
$nama = ''; 
$password = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  include 'koneksi.php'; 
  $email = $_POST['email']; 
  $nama = $_POST['nama']; 
  $password = $_POST['password']; 
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 

  $stmt = $conn->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, 'user')"); 
  $stmt->bind_param("sss", $email, $hashedPassword, $nama); 

  if ($stmt->execute()) { 
    echo "<script>alert('Registrasi berhasil!'); window.location.href='login.php';</script>"; 
    $email = $nama = $password = ''; 
  } else { 
    echo "Registrasi gagal: " . $conn->error; 
  } 
  $stmt->close(); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
    }
    .register-form {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .logo {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }
  </style>
</head>
<body>
  <div class="register-form">
    <div class="logo">
      <img src="cart-removebg-preview.png" alt="Logo">
    </div>
    <form method="POST">
      <div class="mb-3">
        <label for="nama" class="form-label">name</label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama) ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <p class="text-center mt-3">already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
