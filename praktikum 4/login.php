<?php
session_start();
require_once('lib/db_login.php');

// Initialize variables
$email = $password = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use 'email' and 'password' as the field names
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    
    if (empty($email) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Validate credentials
        $query = "SELECT * FROM bookorama.admin WHERE email = ? AND password = ?";
        $stmt = $db->prepare($query);
        if ($stmt) {
            // Assuming the password is stored as plaintext (it's recommended to hash the password)
            $stmt->bind_param("ss", $email, $password); 
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // If login is successful, set session and redirect
                $_SESSION['email'] = $email;
                $_SESSION['is_admin'] = true; // Assuming only admins can log in
                header("Location: view_customer.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
            $stmt->close();
        } else {
            $error = "Failed to prepare SQL statement.";
        }
    }
}

$db->close();

function test_input($data) {
    return htmlspecialchars(trim($data));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
