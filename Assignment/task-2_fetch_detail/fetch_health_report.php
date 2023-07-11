<?php
// Database connection details
$host = "localhost";
$username = "root";
$password = "Deepak2511$";
$database = "deepu";

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST["email"];

  // Prepare and execute the SQL query
  $stmt = $conn->prepare("SELECT health_report FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($healthReport);

  if ($stmt->fetch()) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=health_report.pdf");
    echo $healthReport;
  } else {
    echo "No health report found for the given email ID.";
  }

  $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>
