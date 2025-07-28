<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - Ticket Booking</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('https://images.unsplash.com/photo-1518549182256-1a46f9bdfd89') no-repeat center center/cover;
      font-family: 'Segoe UI', sans-serif;
      color: white;
    }
    .container {
      background: rgba(0, 0, 0, 0.75);
      margin: 80px auto;
      padding: 40px;
      max-width: 600px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 0 25px rgba(255,255,255,0.2);
    }
    h1 {
      font-size: 36px;
      margin-bottom: 20px;
    }
    .btn {
      background-color: #3498db;
      border: none;
      padding: 15px 30px;
      margin: 10px;
      font-size: 18px;
      border-radius: 8px;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .btn:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h1>
    <p>Ready to book your next ticket?</p>
    <a href="book_ticket.php"><button class="btn">🎟️ Book Ticket</button></a>
    <a href="logout.php"><button class="btn" style="background:#e74c3c;">🚪 Logout</button></a>
  </div>
</body>
</html>
