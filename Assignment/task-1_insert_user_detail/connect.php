<?php
// Database connection details
$host = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  $age = $_POST["age"];
  $weight = $_POST["weight"];
  $email = $_POST["email"];
  $healthReport = $_FILES["healthReport"];

  // Validate and process the uploaded file
  if ($healthReport["error"] === UPLOAD_ERR_OK) {
    $tempFilePath = $healthReport["tmp_name"];
    $reportData = file_get_contents($tempFilePath);

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO users (name, age, weight, email, health_report) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sidsb", $name, $age, $weight, $email, $reportData);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      echo "User details and health report uploaded successfully.";
    } else {
      echo "Error occurred while inserting data into the database.";
    }

    $stmt->close();
  } else {
    echo "Error uploading health report.";
  }
}

// Close the database connection
mysqli_close($conn);
?>
