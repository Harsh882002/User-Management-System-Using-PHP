<?php
include("database.php");
// session_start();
include("middleware.php");

$error = "";


if (isset($_POST['submit'])) {
    $userid = isset($_POST['userid']) ? $_POST['userid'] : '';

    $name = isset($_POST['name']) ? $_POST['name'] : '';

    $salary = isset($_POST['salary']) ? $_POST['salary'] : "";

    $city = isset($_POST['city']) ? $_POST['city'] : "";

    $status = isset($_POST['status']) ? $_POST['status'] : "";


    $valid = true;
    if(empty($name)){
        $error = "Enter field";
        $valid = false;
    }

if($valid){

    //Handle file upload
    $image = $_FILES['image'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadok = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
        $uploadok = 1;
    } else {
        echo "file is not an image";
        $uploadok = 0;
    }

    //check if image is already exist
    // if (file_exists($target_file)) {
    //     echo  '<script>alert("Sorry, File already exitst")</script>';
    //     $uploadok = 0;
    // }

    //check file size(less than 1 mb)
    if ($_FILES['image']['size'] > 1000000) {
        echo  '<script>alert("file is too largre")</script>';
        $uploadok = 0;
    }

    //Allow certain Formats
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedTypes)) {
        echo  '<script>alert("sorry only JPG, JPEG, PNG & GIF files are allowed. ")</script>';
        $uploadok = 0;
    }

    if ($uploadok == 0) {
        echo "Sorry your file not submit";
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            $sql = "insert into users(userid,name,salary,city,image,status) values ('$userid','$name','$salary','$city','$target_file','$status')";

            $result = $connect->query($sql);
            // print_r($result);

            if ($result) {
                echo  '<script>alert("data Succefully added")</script>';
            } else {
                echo '<script>alert("Something went rong or userid already presen.")</script>';
            }
        }
        }
    }
}


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
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <button class="btn6"> <a href="logout.php" >Log Out</a></button>

    <button class="btn5"><a href="students.php">All Students</a></button>

    <body>
        <center>
            
            <form action="add_user.php" method="POST" enctype="multipart/form-data" class="fo2">
                 
                <h1>ADD USER</h1>
                <hr>
                <br>    
                <label for="" class="la">EmailID: </label>
                <input type="email" name="userid" placeholder="Enter userid" >
                <br><br><br>
                <label for="" class="la">Name: </label>
                <input type="text" name="name" placeholder="your Name" >
                <span><?php echo $error; ?></span>
                <br><br><br>
                <label for="" class="la">Salary: </label>
                <input type="text" name="salary" placeholder="Enter your salary" >
                <br><br><br>
                <label for="" class="la">City: </label>
                <input type="text" name="city" placeholder="Enter your city" >
                <br><br><br>
                <label for="Image" class="la">Image: </label>
                <input type="file" name="image" accept="image/*" required>

                <label for="" class="la">Status: </label>
                <select name="status" id="status" required>status
                    <option value="">None</option>
                    <option value="blocked">Blocked</option>
                    <option value="active">Active</option>
                    <option value="inactive">inactive</option>
                </select>
                <br><br><br>
                <input type="submit" name="submit" class="btn7">
                <br><br>
        </center>
        
        </form>
    </body>

    </html>
</body>

</html>