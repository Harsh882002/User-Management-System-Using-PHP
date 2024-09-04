<?php

include('database.php');

// $userid = isset($_GET['userid'])? $_GET['userid']:"";



$sql = $connect -> query('SELECT userid,name,salary from users');

$users = $sql -> fetch_all(MYSQLI_ASSOC);
//  print_r($users) ;

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=users_data.csv');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output column headings
fputcsv($output, ['id','UserID', 'Name', 'Salary', 'City']);

// Query the database
$sql = "SELECT * FROM users";
$result = $connect->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch all rows as an associative array
    while ($row = $result->fetch_assoc()) {
        // Write each row of data to the CSV file
        fputcsv($output, [$row['id'],$row['userid'], $row['name'], $row['salary'], $row['city'], $row['image']]);
    }
} else {
    // Write an empty row if there are no results
    fputcsv($output, []);
}

// Close the file pointer and database connection
fclose($output);
$connect->close();
?>

 