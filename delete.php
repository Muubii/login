<?php 
$servername = "docker-mysql-1";
$dbUsername = "root"; 
$password = "password";
$database = "login";

// Create connection
$connection = new mysqli($servername, $dbUsername, $password, $database);

session_start(); 

if (isset($_GET['username'])) {
    $username = $connection->real_escape_string($_GET['username']);

    $query = "DELETE FROM inloggegevens WHERE username = ?";
    $stmt = $connection->prepare($query);
    
    if (!$stmt) {
        die("Prepare failed: " . $connection->error);
    }
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        header('Location: crud.php');
        exit();
    } else {
        die("Execute failed: " . $stmt->error);
    }
    $stmt->close();
}

$connection->close();
?>
