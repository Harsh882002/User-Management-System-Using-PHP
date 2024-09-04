<?php
include('database.php');
include('middleware.php');


// Fetch user data
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);  // Ensure ID is an integer

    // Prepare and execute a query to fetch data
    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo '<script>alert("Error fetching data: ' . $connect->error . '");</script>';
    }
    $stmt->close();
}

// Handle form submission
if (isset($_POST['submit'])) {
    $userid = isset($_POST['userid']) ? $_POST['userid'] : "";
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $salary = isset($_POST['salary']) ? $_POST['salary'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';

    // Prepare and execute a query to update data
    $stmt = $connect->prepare("UPDATE users SET userid = ?, name = ?, salary = ?, city = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $userid, $name, $salary, $city, $id);

    if ($stmt->execute()) {
        echo '<script>alert("Data updated successfully");</script>';
        header("Location: students.php");  // Redirect to listing page
        exit();
    } else {
        echo '<script>alert("Error updating data: ' . $stmt->error . '");</script>';
    }
    $stmt->close();
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
<button class="btn6"> <a href="logout.php" >Log Out</a></button>

<button class="btn5"><a href="students.php">All Students</a></button>
    <center>
        <form action="edit.php?id=<?php echo $user['id'] ?>" method="POST" class="fo3">
            <h1>Edit User</h1>
            <hr>
            <br>

        <label for="">Email:</label>
        <input type="email" name="emai" placeholder="Enter Email" value="<?php echo htmlspecialchars($user['userid']); ?>" required>
            <br><br><br>
            <label for="">Name:</label>
            <input type="text" name="name" placeholder="Enter your Name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <br><br><br>
            <label for="">Salary:</label>
            <input type="text" name="salary" placeholder="Enter your salary" value="<?php echo htmlspecialchars($user['salary']); ?>" re>
            <br><br><br>
            <label for="">City:</label>
            <input type="text" name="city" placeholder="Enter your city" value="<?php echo htmlspecialchars($user['city']); ?>">
            <br><br><br>
            <button type="submit" name="submit" class="btn7">Edit</button>
            <br><br>
        </form>
    </center>

</body>

</html>