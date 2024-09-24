<?php
require_once('lib/db_login.php'); // Include database connection

// Initialize variables
$name = $address = $city = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input and sanitize
    $name = test_input($_POST["name"]);
    $address = test_input($_POST["address"]);
    $city = test_input($_POST["city"]);

    // Validate input
    if (empty($name) || empty($address) || empty($city)) {
        $error = "All fields are required.";
    } else {
        // Prepare SQL query
        $query = "INSERT INTO customers (name, address, city) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("sss", $name, $address, $city);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                echo "<script>
                    alert('Customer added successfully.');
                    window.location.href = 'http://localhost/prak4/view_customer.php';
                </script>";
                exit();
            }else {
                $error = "Failed to add customer.";
            }
            
            $stmt->close();
        } else {
            $error = "Failed to prepare SQL statement.";
        }
    }
}

// Close database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">Add Customer</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>">
                    </div>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                    <a href="view_customer.php" class="btn btn-secondary">Back to Customer List</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
