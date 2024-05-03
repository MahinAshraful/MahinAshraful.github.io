<?php
$host = '127.0.0.1'; 
$dbname = 'bmcc';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$description = $_POST['userInput'];
$dueDate = $_POST['datePicker'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO notes (description, due_date) VALUES (?, ?)");
$stmt->bind_param("ss", $description, $dueDate);

// Execute
$stmt->execute();

// Redirect back to the main page
header("Location: work.php"); // Ensure the filename matches your main HTML file

$stmt->close();
$conn->close();
?>