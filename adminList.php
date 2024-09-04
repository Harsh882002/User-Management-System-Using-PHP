<?php
include("database.php");

    $sql = "select * from admindata";
    $result = $connect->query($sql);
    
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>password</th>
        </thead>
        </tr>
<?php while($row  = mysqli_fetch_assoc($result)) :?>
        <tbody>
            <tr>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['password']?></td>
            </tr>
        </tbody>
        <?php endwhile;?>
    </table>

</body>

</html>