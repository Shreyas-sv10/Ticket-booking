<?php
// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Database connection
    $conn = new mysqli("localhost", "root", "", "ticket_db");

    // Check DB connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input safely
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if user already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "Email already registered!";
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
    if ($conn->query($sql) === TRUE) {
        echo "Registered successfully! <a href='login.html'>Click here to login</a>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!-- Registration Form UI -->
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <style>
    body {
      background: #1e1e2f;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: #2c2f4a;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.5);
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
      background: #ff4c60;
      color: white;
      padding: 10px;
      border: none;
      width: 100%;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background: #e03e50;
    }
  </style>
</head>
<body>
  <form method="POST" action="register.php">
    <h2>Register</h2>
    <input type="text" name="name" placeholder="Full Name" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Register</button>
  </form>
</body>
</html>
