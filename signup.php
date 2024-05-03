<!DOCTYPE html>
<html>
<body>

<h2>Sign Up</h2>

<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bmcc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$emplid = $_POST["emplid"];
$fName = $_POST["fName"];
$lName = $_POST["lName"];
$pass = $_POST["pass"];
$position = $_POST["position"];

$sql = "INSERT INTO userinfo (emplid, fName, lName, pass, position)
VALUES ('$emplid', '$fName', '$lName', '$pass', '$position')";


if ($conn->query($sql) == TRUE) {
  echo "Account Created Succesfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<br><br>
<a href="login.html">Return to Login</a>

</body>
</html>