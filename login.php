<?php
// Replace these variables with your own database connection details
$host = '127.0.0.1';
$db   = 'bmcc';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Sanitize the inputs
$emplid = filter_input(INPUT_POST, 'emplid', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Prepare SQL statement to prevent SQL injection
$stmt = $pdo->prepare("SELECT * FROM userinfo WHERE emplid = :emplid AND pass = :password");
$stmt->execute(['emplid' => $emplid, 'password' => $password]);

$user = $stmt->fetch();

if ($user) {
    // Check the position and redirect accordingly
    if ($user['position'] === 'student') {
        header("Location: homeS.html"); // Redirect to the student home page
    } elseif ($user['position'] === 'teacher') {
        header("Location: homeT.html"); // Redirect to the teacher home page
    } else {
        // Handle other positions or unexpected values if necessary
        echo 'Access denied. Unrecognized position.';
    }
    exit;
} else {
    // Invalid credentials
    echo 'Login failed. Invalid EMPLID or password.';
    // Optionally, redirect back to the login page or show an error message
}
?>