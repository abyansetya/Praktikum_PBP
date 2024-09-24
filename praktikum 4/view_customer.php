<?php

    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
        header("Location: login.php");
        exit();
    }

    // Include database connection
    require_once('lib/db_login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Customers Data
                <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
            </div>    
            <div class="card-body">
                <a class="btn btn-primary mb-3" href="add_customer.php">+ Add Customer Data</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        


                        // Execute query to fetch customer data
                        $query = "SELECT * FROM customers ORDER BY customerid";
                        $result = $db->query($query);
                        if (!$result) {
                            die("Could not query the database: <br />" . $db->error . "<br>Query: " . $query);
                        }

                        // Display each row of customer data
                        $i = 1;
                        while ($row = $result->fetch_object()) {
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . htmlspecialchars($row->name) . '</td>';
                            echo '<td>' . htmlspecialchars($row->address) . '</td>';
                            echo '<td>' . htmlspecialchars($row->city) . '</td>';
                            echo '<td>';
                            echo '<a class="btn btn-warning btn-sm" href="edit_customer.php?id=' . $row->customerid . '">Edit</a>&nbsp;&nbsp;';
                            echo '<a class="btn btn-danger btn-sm" href="delete_customer.php?id=' . $row->customerid . '">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
                <div>
                    <?php
                    echo 'Total Rows = ' . $result->num_rows;
                    $result->free();
                    $db->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
