<?php
require_once('lib/db_login.php'); // Include database connection

// Initialize variables
$error = '';
$customer_id = $_GET['id'] ?? null;  // Get the customer ID from the URL

// Check if customer ID is provided
if (!$customer_id) {
    echo "<script>alert('No customer ID provided.'); window.location.href = 'view_customer.php';</script>";
    exit();
}

// Prepare and execute the delete query
$query = "DELETE FROM customers WHERE customerid = ?";
$stmt = $db->prepare($query);
if ($stmt) {
    // Bind the customer ID to the query
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // If deletion is successful, redirect to the customer list
        echo "<script>
            alert('Customer deleted successfully.');
            window.location.href = 'view_customer.php';
        </script>";
        exit();
    } else {
        $error = "Failed to delete customer. Customer ID may not exist.";
    }
    
    $stmt->close();
} else {
    $error = "Failed to prepare SQL statement.";
}

// Close database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
</head>
<body>
    <div class="container">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
