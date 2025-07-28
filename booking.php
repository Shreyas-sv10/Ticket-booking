<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "ticket_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event = mysqli_real_escape_string($conn, $_POST['event']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $seats = intval($_POST['seats']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO bookings (user_id, event_name, event_date, event_time, seats) 
            VALUES ('$user_id', '$event', '$date', '$time', '$seats')";

    if ($conn->query($sql) === TRUE) {
        $success = "🎉 Ticket Booked Successfully!";
    } else {
        $success = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book Tickets</title>
  <style>
    body {
      background: linear-gradient(135deg, #1e1e2f, #0f0f1a);
      color: white;
      font-family: 'Segoe UI', sans-serif;
      padding: 50px;
    }
    .form-container {
      max-width: 500px;
      margin: auto;
      background: #2b2b3d;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
    }
    input, select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
    }
    button {
      width: 100%;
      padding: 15px;
      background: #2ecc71;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }
    button:hover {
      background: #27ae60;
    }
    .success {
      text-align: center;
      margin-top: 15px;
      color: #f1c40f;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>🎟️ Book Your Ticket</h2>
    <form method="POST" action="">
      <label for="event">Event / Movie Name</label>
      <input type="text" name="event" required>

      <label for="date">Date</label>
      <input type="date" name="date" required>

      <label for="time">Time</label>
      <select name="time" required>
        <option value="10:00 AM">10:00 AM</option>
        <option value="1:00 PM">1:00 PM</option>
        <option value="4:00 PM">4:00 PM</option>
        <option value="7:00 PM">7:00 PM</option>
      </select>

      <label for="seats">Number of Tickets</label>
      <input type="number" name="seats" min="1" max="10" required>

      <button type="submit">✅ Book Now</button>
    </form>
    <?php if ($success) echo "<div class='success'>$success</div>"; ?>
  </div>
</body>
</html>
