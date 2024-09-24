<?php
require_once('lib/db_login.php'); // Include database connection

// Initialize variables
$name = $address = $city = '';
$error = '';
$customer_id = $_GET['id'];

// Fetch the customer's current data
$query = "SELECT name, address, city FROM customers WHERE customerid = ?";
$stmt = $db->prepare($query);
if ($stmt) {
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($name, $address, $city);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "<script>alert('Failed to fetch customer data.'); window.location.href = 'view_customer.php';</script>";
    exit();
}

// Handle form submission for updating the customer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input and sanitize
    $name = test_input($_POST["name"]);
    $address = test_input($_POST["address"]);
    $city = test_input($_POST["city"]);

    // Validate input
    if (empty($name) || empty($address) || empty($city)) {
        $error = "All fields are required.";
    } else {
        // Prepare SQL query for updating customer
        $query = "UPDATE customers SET name = ?, address = ?, city = ? WHERE customerid = ?";
        $stmt = $db->prepare($query);
        
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("sssi", $name, $address, $city, $customer_id);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                echo "<script>
                    alert('Customer updated successfully.');
                    window.location.href = 'view_customer.php';
                </script>";
                exit();
            } else {
                $error = "No changes were made or failed to update customer.";
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
    <title>Edit Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">Edit Customer</div>
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
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                    <a href="view_customer.php" class="btn btn-secondary">Back to Customer List</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
