<?php
session_start();

// Connect to DB
$conn = new mysqli("localhost", "root", "", "ticket_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: home.php"); // Redirect to dashboard/home page
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!-- Login Form UI -->
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body {
      background: #0e0e1a;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: #2e2e42;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.6);
      width: 300px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
    }
    button {
      background: #2ecc71;
      color: white;
      padding: 10px;
      border: none;
      width: 100%;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background: #27ae60;
    }
    .error {
      color: #ff4c4c;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <form method="POST" action="login.php">
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <p style="margin-top:10px;">Don't have an account? <a href="register.php" style="color:#f39c12;">Register</a></p>
  </form>
</body>
</html>
