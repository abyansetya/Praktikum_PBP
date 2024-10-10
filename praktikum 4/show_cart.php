<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
  header('Location: ./login.php');
  exit;
}

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

// Add item to cart if ID is passed
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];

  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
  } else {
    $_SESSION['cart'][$id] = 1;
  }
}

include('./header.php');
?>
<br>
<div class="card mt-4">
  <div class="card-header">Shopping Cart</div>
  <div class="card-body">
    <br>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ISBN</th>
          <th>Author</th>
          <th>Title</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Total Price</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once('./lib/db_login.php');

        $sum_qty = 0;
        $sum_price = 0;

        if (!empty($_SESSION['cart'])) {
          // Use prepared statement to prevent SQL injection
          $stmt = $db->prepare("SELECT isbn, author, title, price FROM books WHERE isbn = ?");

          foreach ($_SESSION['cart'] as $id => $qty) {
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $total_price = $row['price'] * $qty;
                echo "<tr>
                        <td>{$row['isbn']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['title']}</td>
                        <td>\${$row['price']}</td>
                        <td>{$qty}</td>
                        <td>\${$total_price}</td>
                      </tr>";

                $sum_qty += $qty;
                $sum_price += $total_price;
              }
            } else {
              echo "<tr><td colspan='6'>Book with ISBN $id not found</td></tr>";
            }
          }

          $stmt->close();
        } else {
          echo '<tr><td colspan="6" align="center">There are no items in the shopping cart</td></tr>';
        }

        $db->close();
        ?>
      </tbody>
    </table>
    <p>Total items: <?php echo $sum_qty; ?></p>
    <p>Total price: $<?php echo number_format($sum_price, 2); ?></p>

    <a class="btn btn-primary" href="view_books.php">Continue Shopping</a>
    <a class="btn btn-danger" href="delete_cart.php">Empty Cart</a>
  </div>
</div>

<?php include('./footer.php'); ?>
