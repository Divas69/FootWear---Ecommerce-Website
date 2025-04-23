<?php include('layouts/header.php'); ?>
<?php

include('server/connection.php');

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
  exit;
}

// Handle logout
if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  header('location: login.php');
  exit;
}

// Handle password change
if (isset($_POST['change_password'])) {
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $user_email = $_SESSION['user_email'];

  if ($password !== $confirmPassword) {
    header('location: account.php?error=Passwords do not match');
  } elseif (strlen($password) < 8) {
    header('location: account.php?error=Password must be at least 8 characters');
  } else {
    $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
    $hashedPassword = md5($password);
    $stmt->bind_param('ss', $hashedPassword, $user_email);

    if ($stmt->execute()) {
      header('location: account.php?message=Password updated successfully');
    } else {
      header('location: account.php?error=Could not update password');
    }
  }
}

// Fetch user orders
if (isset($_SESSION['logged_in'])) {
  $user_id = $_SESSION['user_id'];
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
  $stmt->bind_param('i', $user_id);
  $stmt->execute();
  $orders = $stmt->get_result();
}

?>

<!-- Account Section -->
<section class="my-5 py-3">
  <div class="container">
    <div class="row">
      <!-- Account Info -->
      <div class="col-lg-6 col-md-12 text-center">
        <h3 class="font-weight-bold">Account Info</h3>
        <hr class="mx-auto" />
        <div class="account-info">
          <p><strong>Name:</strong> <span><?php echo $_SESSION['user_name'] ?? ''; ?></span></p>
          <p><strong>Email:</strong> <span><?php echo $_SESSION['user_email'] ?? ''; ?></span></p>
          <p><a href="#orders" class="btn btn-outline-primary">Your Orders</a></p>
          <p><a href="account.php?logout=1" class="btn btn-danger">Logout</a></p>
        </div>
      </div>

      <!-- Change Password -->
      <div class="col-lg-6 col-md-12">
        <form method="POST" action="account.php" class="p-4 shadow rounded">
          <h3>Change Password</h3>
          <hr />
          <div class="form-group mb-3">
            <label for="password">New Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password" required />
          </div>
          <div class="form-group mb-3">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm new password" required />
          </div>
          <button type="submit" name="change_password" class="btn btn-primary w-100">Change Password</button>
          <p class="text-center mt-3 text-danger"><?php echo $_GET['error'] ?? ''; ?></p>
          <p class="text-center mt-3 text-success"><?php echo $_GET['message'] ?? ''; ?></p>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Orders Section -->
<section id="orders" class="container my-5 py-3">
  <div class="text-center">
    <h2 class="font-weight-bold">Your Orders</h2>
    <hr class="mx-auto" />
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover mt-4">
      <thead class="table-dark">
        <tr>
          <th>Order ID</th>
          <th>Order Cost</th>
          <th>Order Status</th>
          <th>Order Date</th>
          <th>Order Details</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $orders->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['order_cost']; ?></td>
            <td><?php echo $row['order_status']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
            <td>
              <form method="POST" action="order_details.php">
                <input type="hidden" name="order_status" value="<?php echo $row['order_status']; ?>" />
                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>" />
                <button type="submit" name="order_details_btn" class="btn btn-info">Details</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</section>

<?php include('layouts/footer.php'); ?>
