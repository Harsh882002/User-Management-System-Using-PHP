<?php

include('database.php');
// session_start();


$namerror = $passerror = "";
$username = $password = " ";
if (isset($_POST['submit'])) {
  extract($_POST);


  // Extracts and sanitizes user inputs
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $isvalid = true;

  if (empty($username)) {
    $namerror = "please Enter password";
    $isvalid =  false;
  }

  if(empty($password)){
    $passerror = "Please filled password";
    $isvalid = false;
  }

  if ($isvalid) {

    $sql = $connect->prepare("SELECT * FROM admindata WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    // Check if the user exists
    if ($result->num_rows === 1) {
      // Fetch user data using mysqli_fetch_assoc
      $user = mysqli_fetch_assoc($result);

      // Verify password (assuming passwords are hashed)
      if ($password === $user['password']) {
        // Set session variables
        $_SESSION['is_user_loggedin'] = true;
        $_SESSION['user_data'] = $user;

        header("LOCATION: students.php");
        exit();
      } else {
        echo '<script>alert("Username or password something went wrong");</script>';
      }
    } else {
      echo '<script>alert("Username or password something went wrong");</script>';
    }

    $sql->close();
  }
}
$connect->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<link rel="stylesheet" href="style.css">

<body>
  <center>
    <form action="list.php" method="POST" class="fo1">
      <h1>ADMIN LOGIN</h1>
      <hr>
      <br>
      <label for="" class="l1">Username</label>
      <br>
      <input type="text" placeholder="Enter Username" name="username" class="i1"> <br>
      <span class="error"><?php echo $namerror; ?></span><br><br>

      <br><br>
      <label for="" class="l1">Password </label>
      <br>
      <input type="password" placeholder="Enter Password" name="password" class="i1"> <br>
      <span><?php echo $passerror; ?></span>
      <br><br><br>
      <input type="submit" name="submit" class="btn7">
      <br><br>
    </form>
  </center>

  <button class="btn1"><a href="admin.php">Create Admin</a>
  </button>
</body>

</html>