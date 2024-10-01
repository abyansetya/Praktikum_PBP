<?php
// Establish database connection
$host = 'localhost'; // Adjust accordingly
$user = 'root'; // Adjust accordingly
$password = ''; // Adjust accordingly
$database = 'buku'; // Adjust accordingly

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_GET['title'])) {
    $title = $connection->real_escape_string($_GET['title']);

    // Query to search for book by title
    $query = "SELECT * FROM books WHERE title LIKE '%$title%' LIMIT 5";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h2>" . $row['title'] . "</h2>";
            echo "<p><strong>Author:</strong> " . $row['author'] . "</p>";
            echo "<p><strong>Published Year:</strong> " . $row['year'] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "No books found.";
    }
}

$connection->close();
?>
