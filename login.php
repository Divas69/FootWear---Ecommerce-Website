<?php include('layouts/header.php'); ?>
<?php

include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
  header('location:account.php');
  exit;
}

if (isset($_POST['login_btn'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = ? AND user_password = ? LIMIT 1");

  $stmt->bind_param('ss', $email, $password);

  if ($stmt->execute()) {
    $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
    $stmt->store_result();

    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_name'] = $user_name;
      $_SESSION['user_email'] = $user_email;
      $_SESSION['logged_in'] = true;

      header('location:account.php?login_success=logged in Successfully');
    } else {
      header('location:login.php?error=Could not verify account');
    }
  } else {
    header('location:login.php?error=Something went wrong');
  }
}

?>

<!--Login-->
<section class="my-5 py-5" style="background-color: #f8f9fa;">
  <div class="container text-center mt-3 pt-5">
    <h2 class="font-weight-bold" style="color: #343a40;">Login</h2>
    <p class="text-muted">Access your account and explore premium features</p>
  </div>
  <div class="mx-auto container" style="max-width: 500px; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <form id="login-form" method="POST" action="login.php">
      <p style="color: red;" class="text-center"><?php if (isset($_GET['error'])) { echo $_GET['error']; } ?></p>
      <div class="form-group">
        <label for="email" class="font-weight-bold" style="color: #343a40;">Email</label>
        <input type="email" class="form-control" id="login-email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password" class="font-weight-bold" style="color: #343a40;">Password</label>
        <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary btn-block" id="login-btn" name="login_btn" value="Login" style="background-color: #007bff; border: none;">
      </div>
      <div class="form-group text-center">
        <a id="register-url" href="register.php" class="btn btn-link" style="color: #007bff;">Don't have an account? Register</a>
      </div>
    </form>
  </div>
</section>

<!--Footer-->
<?php include('layouts/footer.php') ?>
