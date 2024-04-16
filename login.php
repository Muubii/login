<?php
$servername = "docker-mysql-1";
$username = "root";
$password = "password";
$database = "login"; 

$conn = new mysqli($servername, $username, $password, $database);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $myusername = ( $_POST['username']);
    $mypassword = ( $_POST['password']);
    
    $query = "SELECT username FROM inloggegevens WHERE username = '$myusername' and password = '$mypassword'";
    
    $result = $conn->query($query);
    
    if ($result->num_rows == 1) {
        $_SESSION['login_user'] = $myusername;
        
        header("location: welcome.php");
    } else {
        $error = "Your Login Name or Password is invalid";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

<div class="login-container">
    <form class="login-form" action="" method="POST">
        <h1>Login</h1>
        <div class="form-field">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        
        <div class="form-field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <a href="register.php">register</a>
            <a href="crud.php">p</a>
        </div>
        
        <?php if(isset($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <button type="submit" name="login">Login</button>
    </form>
</div>



</body>
</html>


<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.login-form h1 {
    color: #333;
    margin-bottom: 24px;
    text-align: center;
}

.form-field {
    margin-bottom: 20px;
}

.form-field label {
    display: block;
    margin-bottom: 8px;
}

.form-field input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

.error-message {
    color: #d9534f;
    margin-bottom: 20px;
}

a{
    color: black;
    text-decoration: none;
}
</style>