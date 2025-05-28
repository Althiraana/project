<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($id, $hash);

  if ($stmt->fetch() && password_verify($password, $hash)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: url('everest.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .login-container {
      max-width: 400px;
      margin: 80px auto;
      padding: 30px;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.2);
      text-align: center;
    }

    .logo img {
      max-width: 100px;
      margin-bottom: 20px;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .input-group {
      margin-bottom: 15px;
      text-align: left;
    }

    .input-group label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }

    .input-group input {
      width: 100%;
      padding: 10px;
      box-sizing: border-box;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .error-message {
      color: red;
      margin-bottom: 15px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }

    p {
      margin-top: 15px;
    }

    a {
      color: #007bff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo">
      <img src="oo.jpg" alt="Logo" />
    </div>

    <form method="post">
      

      <?php if (isset($error)) { ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
      <?php } ?>

      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" required />
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" required />
      </div>

      <button type="submit">Login</button>

      <p>Belum memiliki akun? <a href="register.php">Daftar sekarang!</a></p>
    </form>
  </div>
</body>
</html>





