<?php include('header.php') ?>
<?php

include('../server/connection.php');

if (isset($_SESSION['admin_logged_in'])) {
  header('location: index.php');
  exit;
}

if (isset($_POST['login_btn'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email, admin_password FROM admins WHERE admin_email = ? AND admin_password = ? LIMIT 1");
  $stmt->bind_param('ss', $email, $password);

  if ($stmt->execute()) {
    $stmt->bind_result($admin_id, $admin_name, $admin_email, $admin_password);
    $stmt->store_result();

    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      $_SESSION['admin_id'] = $admin_id;
      $_SESSION['admin_name'] = $admin_name;
      $_SESSION['admin_email'] = $admin_email;
      $_SESSION['admin_logged_in'] = true;

      header('location: index.php?login_success=logged in Successfully');
    } else {
      header('location: login.php?error=Invalid email or password');
    }
  } else {
    header('location: login.php?error=Something went wrong');
  }
}
?>

<main class="container-fluid">
  <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 15px;">
      <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Admin Login</h2>
        <p class="text-muted">Access your admin dashboard</p>
      </div>
      <form id="login-form" method="POST" action="login.php">
        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger text-center" role="alert">
            <?php echo $_GET['error']; ?>
          </div>
        <?php endif; ?>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary btn-lg" name="login_btn">Login</button>
        </div>
      </form>
      <div class="text-center mt-3">
        <a href="#" class="text-decoration-none text-muted">Forgot Password?</a>
      </div>
    </div>
  </div>
</main>
