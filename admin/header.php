<?php session_start(); ?>
<?php include('../server/connection.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ShoeSphere Admin Panel">
    <meta name="author" content="ShoeSphere Team">
    <link rel="icon" href="../assets/imgs/footer-logo.png" type="image/x-icon">
    <title>ShoeSphere Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-color: #fff;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #d1d1d1 !important;
        }

        .header-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 header-shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">ShoeSphere</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['admin_logged_in'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="logout.php?logout=1">Sign Out</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </header>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>