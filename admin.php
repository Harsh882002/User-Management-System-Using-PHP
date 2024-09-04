<?php
include('database.php');
// include("middleware.php");

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Store the password as plaintext (Not recommended for production use)
        $sql = $connect->prepare("INSERT INTO admindata (username, password) VALUES (?, ?)");
        $sql->bind_param("ss", $username, $password);
        $sql->execute();

        if ($sql->affected_rows === 1) {
            echo '<script>alert("Admin user created successfully.");</script>';
            header("Location: index.php");
        } else {
            echo '<script>alert("Error creating admin user.");</script>';
        }

        $sql->close();
    } else {
        echo '<script>alert("Please fill in all fields.");</script>';
    }
}
$connect->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <form action="admin.php" method="POST" class="fo1">
            <h1>ADMIN CREATE</h1>
            <hr>
            <br>
            <label for=""  class="l1">Username</label> <br>
            <input type="text" placeholder="Enter username" name="username" required>
            <br><br>
            <label for=""  class="l1">Password</label>   <br>
            <input type="password" placeholder="Enter password" name="password" required>
            <br><br><br>
            <input type="submit" name="submit" value="Create Admin" class="btn7">
            <br><br><br>
        </form>
    </center>
</body>
</html>