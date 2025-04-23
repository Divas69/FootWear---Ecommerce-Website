<?php include('layouts/header.php'); ?>
<?php
include('server/connection.php');

if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // Validate name
  if (!preg_match('/^[a-zA-Z\s\-\' ]+$/', $name)) {
    header('location:register.php?error=Name must only contain letters, spaces, hyphens (-), or apostrophes (\')');
    exit;
  }

  // Validate email
  if (!preg_match('/^[a-zA-Z]{3,}[0-9]*@[a-zA-Z0-9.-]*[a-zA-Z][a-zA-Z0-9.-]*\.[a-zA-Z]{2,}$/', $email)) {
    header('location:register.php?error=Invalid email format.');
    exit;
  }

  if (is_numeric($email)) {
    header('location:register.php?error=Email must not contain only numbers');
    exit;
  }

  // If passwords don't match
  if ($password !== $confirmPassword) {
    header('location:register.php?error=Passwords do not match');
    exit;
  } else if (strlen($password) < 8) {
    header('location:register.php?error=Password must be at least 8 characters');
    exit;
  } else {
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    if ($num_rows != 0) {
      header('location:register.php?error=User with this email already exists');
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header('location:register.php?error=Invalid email');
    } else {
      $stmt = $conn->prepare("INSERT INTO users(user_name, user_email, user_password) VALUES (?, ?, ?)");
      $stmt->bind_param('sss', $name, $email, md5($password));

      if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['logged_in'] = true;
        header('location:account.php?register_success=You registered successfully');
      } else {
        header('location:register.php?error=Could not create account at the moment');
      }
    }
  }
} else if (isset($_SESSION['logged_in'])) {
  header('location:account.php');
  exit;
}
?>

<!-- Register Section -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="fw-bold">Create Your Account</h2>
    <p class="text-muted">Join us and enjoy exclusive benefits!</p>
  </div>
  <div class="mx-auto container" style="max-width: 500px;">
    <form id="register-form" method="POST" action="register.php" class="p-4 shadow rounded bg-light">
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $_GET['error']; ?>
        </div>
      <?php endif; ?>
      <div class="mb-3">
        <label for="register-name" class="form-label">Name</label>
        <input type="text" class="form-control" id="register-name" name="name" placeholder="Enter your name" required>
      </div>
      <div class="mb-3">
        <label for="register-email" class="form-label">Email</label>
        <input type="email" class="form-control" id="register-email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="mb-3">
        <label for="register-password" class="form-label">Password</label>
        <input type="password" class="form-control" id="register-password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="mb-3">
        <label for="register-confirm-password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm your password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary" name="register">Register</button>
      </div>
      <div class="text-center mt-3">
        <p class="text-muted">Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
      </div>
    </form>
  </div>
</section>

<!-- Footer -->
<?php include('layouts/footer.php'); ?>
