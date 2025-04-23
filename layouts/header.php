<?php

session_start();

include('./server/connection.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShoeSphere</title>
  <link rel="icon" href="assets/imgs/footer-logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="./assets/css/style.css" />
  <style>
    body {
      font-family: 'Arial', sans-serif;
    }

    .navbar {
      background: linear-gradient(90deg, #ff7e5f, #feb47b);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand img {
      height: 50px;
    }

    .nav-link {
      color: white !important;
      font-weight: bold;
      margin: 0 10px;
      transition: color 0.3s ease;
    }

    .nav-link:hover {
      color: #ffe6e1 !important;
    }

    .nav-buttons a {
      color: white;
      font-size: 18px;
      margin: 0 10px;
      position: relative;
      transition: transform 0.3s ease;
    }

    .nav-buttons a:hover {
      transform: scale(1.1);
    }

    .cart-quantity {
      background: #fb774b;
      color: #fff;
      padding: 3px 7px;
      border-radius: 50%;
      font-size: 12px;
      position: absolute;
      top: -5px;
      right: -10px;
    }

    .navbar-toggler {
      border: none;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%280, 0, 0, 0.5%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg py-3 fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="./assets/imgs/mainlogo.png" alt="ShoeSphere Logo" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.php">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
        </ul>
        <div class="d-flex">
          <a href="cart.php">
            <i class="fa-solid fa-cart-shopping">
              <?php if (isset($_SESSION['quantity']) && $_SESSION['quantity'] != 0) { ?>
                <span class="cart-quantity"><?php echo $_SESSION['quantity']; ?></span>
              <?php } ?>
            </i>
          </a>
          <a href="account.php"><i class="fa-solid fa-user"></i></a>
        </div>
      </div>
    </div>
  </nav>
</body>

</html>