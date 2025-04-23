<?php include('header.php'); ?>

<?php if (!isset($_SESSION['admin_logged_in'])) {
    header('location:login.php');
    exit();
}
?>
<?php
// 1. Determine the page number
$page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

// 2. Return number of products
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM orders");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// 3. Products per page
$total_records_per_page = 12;
$offset = ($page_no - 1) * $total_records_per_page;
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// 4. Get all products
$stmt2 = $conn->prepare("SELECT * FROM orders LIMIT $offset, $total_records_per_page");
$stmt2->execute();
$orders = $stmt2->get_result();
?>

<body>
    <div class="container-fluid bg-light">
        <div class="row min-vh-100">
            <?php include('sidemenu.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark fw-bold">Dashboard</h1>
                </div>

                <h2 class="text-secondary fw-semibold">Orders Overview</h2>

                <?php if (isset($_GET['order_updated'])) { ?>
                    <div class="alert alert-success text-center">
                        <i class="bi bi-check-circle-fill"></i> <?php echo $_GET['order_updated']; ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['order_failed'])) { ?>
                    <div class="alert alert-danger text-center">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $_GET['order_failed']; ?>
                    </div>
                <?php } ?>

                <div class="card shadow-lg mt-4 border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0 fw-bold">Order List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Order Id</th>
                                        <th scope="col">Order Status</th>
                                        <th scope="col">User Id</th>
                                        <th scope="col">Order Date</th>
                                        <th scope="col">User Phone</th>
                                        <th scope="col">User Address</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order) { ?>
                                        <tr>
                                            <td><?php echo $order['order_id']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $order['order_status'] == 'Completed' ? 'success' : 'warning'; ?>">
                                                    <?php echo $order['order_status']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $order['user_id']; ?></td>
                                            <td><?php echo date('d M Y, h:i A', strtotime($order['order_date'])); ?></td>
                                            <td><?php echo $order['user_phone']; ?></td>
                                            <td><?php echo $order['user_address']; ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary" href="edit_order.php?order_id=<?php echo $order['order_id']; ?>">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation example" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if ($page_no > 1) echo "?page_no=" . ($page_no - 1); ?>">
                                        <i class="bi bi-chevron-left"></i> Previous
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                                    <li class="page-item <?php if ($page_no == $i) echo 'active'; ?>">
                                        <a class="page-link" href="?page_no=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?php if ($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if ($page_no < $total_no_of_pages) echo "?page_no=" . ($page_no + 1); ?>">
                                        Next <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.2/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
