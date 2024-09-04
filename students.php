<?php

include("database.php");
include("middleware.php");

// Initialize variables
$id = $search = $sort_by = $order = $filter_field = $filter_value = '';
$showData = 4;

// Handle delete request
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize ID

    // Get image path
    $stmt = $connect->prepare("SELECT image FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image'];

        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete user
    $stmt = $connect->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<script>alert("Data deleted successfully")</script>';
    } else {
        echo '<script>alert("Data not deleted")</script>';
    }
}

// Get current page or set default to 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $showData;

// Get sorting parameters
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Get search parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get filter parameters
$filter_field = isset($_GET['filter']) ? $_GET['filter'] : '';
$filter_value = isset($_GET['filter_value']) ? $_GET['filter_value'] : '';

$where_clause = 'WHERE 1=1';
$params = [];
$types = '';

// Add search condition
if ($search) {
    echo   $where_clause .= " AND (name LIKE ? OR userid LIKE ? OR city LIKE ?)";
     $search_param = '%' . $search . '%';
    
    array_push($params, $search_param, $search_param, $search_param);
    $types .= 'sss';
}

// Add filter condition
if ($filter_field && $filter_value) {
    $where_clause .= " AND $filter_field = ?";

    $params[] = $filter_value;
    $types .= 's';
}



// Get total number of users
$stmt = $connect->prepare("SELECT COUNT(*) AS total FROM users $where_clause");
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
// print_r($result);
$row = $result->fetch_assoc();
// print_r($row);
$total_page = ceil($row["total"] / $showData);

// Fetch users with pagination, sorting, filtering, and search
 $sql = "SELECT * FROM users $where_clause ORDER BY $sort_by $order LIMIT ?, ?";
$params = array_merge($params, [$start_from, $showData]);
$types .= 'ii';

$stmt = $connect->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
 
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="btns">
        <button class="btn2"><a href="add_user.php">Add Data</a></button>
        <button class="btn3"> <a href="download.php">Download user</a></button>
        <button class="btn4"><a href="logout.php">Log Out</a></button>
    </div>

    <!-- Searching Form -->
    <div class="chill">
        <form action="students.php" method="GET">
            <input class="s1" type="text" name="search" placeholder="Search...." value="<?php echo htmlspecialchars($search); ?>">
            <input type="submit" value="search">
        </form>
    </div>

    <center>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width: 5%;">ID <button class="sortt"><a href="students.php?sort_by=id&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">&uarr;&darr;</a></button></th>
                    <th style="width: 10%;">Image</th>
                    <th style="width: 10%;">Email ID <button class="sortt"><span><a href="students.php?sort_by=userid&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">&uarr; &darr;</a></span></button></th>
                    <th style="width: 10%;">Name <button class="sortt"><span><a href="students.php?sort_by=name&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">&uarr; &darr;</a></span></button></th>
                    <th style="width: 10%;">City <button class="sortt"><a href="students.php?sort_by=city&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">&uarr;&darr;</a></button></th>
                    <th style="width: 10%;">Salary <button class="sortt"><a href="students.php?sort_by=salary&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">&uarr; &darr;</a></button></th>
                    <th style="width: 10%;">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td style="text-align: center;"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td style="text-align: center;">
                                <?php if ($row['image']): ?>
                                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="user image" style="width: 100px; height:auto;">
                                <?php else: ?>
                                    No image
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;"><?php echo htmlspecialchars($row['userid']); ?></td>
                            <td style="text-align: center;"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td style="text-align: center;"><?php echo htmlspecialchars($row['city']); ?></td>
                            <td style="text-align: center;"><?php echo htmlspecialchars($row['salary']); ?></td>
                            <td style="text-align: center;">
                                <button class="action" style="background-color: green;"> <a href="edit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="edit">Edit</a></button>
                                <button class="action" style="background-color: red;"> <a href="students.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="delete">Delete</a></button>
                                <button class="action" style="background-color: yellowgreen;"> <a href="view.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="view">View</a></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No data found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </center>
    <br><br><br>

    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="item">
                    <button class="prev"><a href="students.php?page=<?php echo $page - 1; ?>">Previous</a></button>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_page; $i++):   ?>
                
                
                
                 <li class="item <?php if ($i == $page) echo 'active'; ?>">
                           
                    <button style="background-color: brown;"> <a class="btn" href="students.php?page=<?php echo $i;?>"><?php echo $i ?></a></button>
                </li>
                
            <?php 
        endfor; ?>


            <li class="item">
                <button class="prev"> <a href="students.php?page=<?php echo $total_page ?>">Last</a></button>
            </li>
        </ul>
    </nav>

</body>

</html>
