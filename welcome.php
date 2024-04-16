<?php
session_start(); 

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="welcome.css">
</head>
<body>

    <div class = "welcome-container">
    <div> <button> <a id = "button" href="logout.php">logout</a></button></div>
    </div>
    <h1 class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['login_user']); ?>!</h1>
    <img src="cat.gif" alt="">
    <img src="monkey.jpeg" alt="">
    <img src="rrrr.jpeg" alt="">


</body>
</html>


