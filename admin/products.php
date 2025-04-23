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
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// 3. Products per page
$total_records_per_page = 12;
$offset = ($page_no - 1) * $total_records_per_page;
$total_no_of_pages = ceil($total_records / $total_records_per_page);

// 4. Get all products
$stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
$stmt2->execute();
$products = $stmt2->get_result();

?>

<div class="container-fluid">
    <div class="row" style="min-height: 1000px">
        <?php include('sidemenu.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <h2 class="mb-4">Products</h2>

            <!-- Display Messages -->
            <?php
            $messages = [
                'edit_success_message' => 'green',
                'edit_failure_message' => 'red',
                'deleted_successfully' => 'green',
                'deleted_failure' => 'red',
                'product_created' => 'green',
                'product_failed' => 'red',
                'image_updated' => 'green',
                'image_failed' => 'red'
            ];
            foreach ($messages as $key => $color) {
                if (isset($_GET[$key])) {
                    echo "<p class='text-center text-$color'>" . htmlspecialchars($_GET[$key]) . "</p>";
                }
            }
            ?>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Product Id</th>
                            <th scope="col">Product Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Product Offer</th>
                            <th scope="col">Product Category</th>
                            <th scope="col">Product Color</th>
                            <th scope="col">Edit Images</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) { ?>
                            <tr>
                                <td><?php echo $product['product_id']; ?></td>
                                <td><img src="<?php echo "../assets/imgs/" . $product['product_image']; ?>" class="img-thumbnail" style="width:70px; height:70px;"></td>
                                <td><?php echo $product['product_name']; ?></td>
                                <td><?php echo "Rs. " . $product['product_price']; ?></td>
                                <td><?php echo $product['product_special_offer'] . "%"; ?></td>
                                <td><?php echo $product['product_category']; ?></td>
                                <td><?php echo $product['product_color']; ?></td>
                                <td><a class="btn btn-warning btn-sm" href="<?php echo "edit_images.php?product_id=" . $product['product_id'] . "&product_name=" . $product['product_name']; ?>">Edit Images</a></td>
                                <td><a class="btn btn-primary btn-sm" href="edit_product.php?product_id=<?php echo $product['product_id']; ?>">Edit</a></td>
                                <td><a class="btn btn-danger btn-sm" href="delete_product.php?product_id=<?php echo $product['product_id']; ?>">Delete</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if ($page_no > 1) echo "?page_no=" . ($page_no - 1); else echo '#'; ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
                            <li class="page-item <?php if ($page_no == $i) echo 'active'; ?>">
                                <a class="page-link" href="?page_no=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <li class="page-item <?php if ($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if ($page_no < $total_no_of_pages) echo "?page_no=" . ($page_no + 1); else echo '#'; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.2/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
