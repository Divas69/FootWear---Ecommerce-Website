<?php
// Start the session
session_start();

// Check if the logout parameter is set and valid
if (!empty($_GET['logout']) && $_GET['logout'] == 1) {
  // Check if the admin is logged in
  if (!empty($_SESSION['admin_logged_in'])) {
    // Clear admin session data
    session_unset();
    session_destroy();

    // Redirect to the login page with a success message
    header('Location: login.php?message=logout_success');
    exit;
  }
}

// If accessed directly, redirect to the login page
header('Location: login.php');
exit;
