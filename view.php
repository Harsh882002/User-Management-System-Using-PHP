 <?php

    use LDAP\Result;

    include('database.php');
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $id =  $_GET['id'];

        //use parametarized query to prevent SQL injection
        $sql = $connect->prepare("SELECT * FROM users WHERE id = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
        $result = $sql->get_result();

        if (!$result) {
            die("query failed " . $connect->error);
        }

        $row = $result->fetch_assoc();
    } else {
        echo "INVALID ID";
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
     <div>
         <?php
            if ($row) {

                $imagepath = $row['image'];
                $name = htmlspecialchars($row['name']);
                $userid = htmlspecialchars($row['userid']);
                $salary = htmlspecialchars($row['salary']);
                $city = htmlspecialchars($row['city']);
            }
            ?>

         <center> <img src="<?php echo $imagepath ?>" alt="img" style="width: 120px; height:auto;" class="user">
         <div class="data">
             <h1>User Id: <?php echo $userid ?></h1>
             <h1>Name: <?php echo $name ?></h1>
             <h1>Salary: <?php echo $salary  ?></h1>
             <h1>City: <?php echo $city ?></h1>

             </div>

         </center>

     </div>
 </body>

 </html>