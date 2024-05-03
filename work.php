<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Manager</title>
    <link rel="stylesheet" type="text/css" href="work.css" /> 
</head>
<body>
    <form id="workForm" method="POST" action="add_note.php">
        <label for="userInput">Work Description</label>
        <input type="text" id="userInput" name="userInput" required>
        <br><br>

        <label for="datePicker">Due Date:</label>
        <input type="date" id="datePicker" name="datePicker" required>
        <br><br>

        <input type="submit" value="Submit">
    </form>

    <div id="workDetails">
    <?php
// Set the timezone to UTC
date_default_timezone_set('UTC');

$host = '127.0.0.1'; 
$dbname = 'bmcc';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT description, due_date FROM notes ORDER BY due_date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $currentDate = new DateTime(null, new DateTimeZone('UTC')); // Set timezone to UTC
        $dueDate = new DateTime($row["due_date"], new DateTimeZone('UTC')); // Set timezone to UTC
        $interval = $currentDate->diff($dueDate);
        $daysDiff = $interval->days;

        echo "<div>";
        echo "<p>Work Description: " . $row["description"] . "</p>";
        echo "<p>Due Date: " . $dueDate->format('D, d M Y') . " (" . $daysDiff . " day(s) remaining)</p>";
        echo "<hr>";
        echo "</div>";
    }
} else {
    echo "No notes found.";
}
$conn->close();
?>

    </div>
</body>
</html>