<?php 
$servername = "docker-mysql-1";
$dbUsername = "root";
$password = "password";
$database = "login";

$connection = new mysqli($servername, $dbUsername, $password, $database);

session_start(); 

$originalUsername = $_GET['username'] ?? null;

$user = null;
if ($originalUsername) {
    $stmt = $connection->prepare("SELECT username, password FROM inloggegevens WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $originalUsername);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $connection->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $originalUsername = $_POST['original_username']; // Retrieved from hidden form field
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password']; 

    $stmt = $connection->prepare("UPDATE inloggegevens SET username = ?, password = ? WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("sss", $newUsername, $newPassword, $originalUsername);
        if ($stmt->execute()) {
            header('Location: crud.php'); 
}
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="crud.css">
</head>
<body>
    <h2>Update User</h2>
    <form class="registration-form" action="" method="POST">
        <input type="hidden" name="original_username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter new password" required>
        
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
