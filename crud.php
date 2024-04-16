<?php
session_start();
$servername = "docker-mysql-1";
$username = "root";
$password = "password";
$database = "login";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['register'])) {
        $myusername = $_POST['username'];
        $mypassword = $_POST['password'];
        $stmt = $conn->prepare("INSERT INTO inloggegevens (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $myusername, $mypassword);
        if ($stmt->execute()) {
            header('Location: crud.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="crud.css">
    <style>
        table, tr, td {
            border: solid 1px black;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
        }
    </style>
</head>
<body>
    <table>
      <thead>
        <tr>
          <th>username</th>
          <th>password</th>
        </tr>

      </thead>
        <div class="container">
            <button type="submit" class="btn" onclick="openPopup()">add</button>

            <div class="popup" id="popup">
                <form class="registration-form" action="crud.php" method="POST">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <button type="button" onclick="closePopup()">Close</button>
                    <button type="submit" name="register">Submit</button>
                </form>
            </div>
        </div>
        <script>
        let popup = document.getElementById("popup");
        
        function openPopup() {
            popup.classList.add("open-popup");
        }
        
        function closePopup() {
            popup.classList.remove("open-popup");
        }
        </script>
        
        <?php
        // Db query 
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM inloggegevens";
        if ($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
        
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                echo "<td><a href='update.php?username=" . htmlspecialchars($row['username']) . "' class='btn'>update</a></td>";
                echo "<td><a href='delete.php?username=" . htmlspecialchars($row['username']) . "' class='btn '>delete</a></td>"; 
            }
        }
        
        $conn->close();
        ?>
        
    </table>
    <a href="login.php">login</a>
</body>
</html>
