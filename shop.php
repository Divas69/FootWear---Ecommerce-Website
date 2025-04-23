<?php include('layouts/header.php'); ?>
<?php include('server/connection.php');

// Use the search section
if (isset($_POST['search'])) {
  // Determine the page number
  $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

  $category = $_POST['category'];
  $price = $_POST['price'];

  // Return number of products
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products WHERE product_category = ? AND product_price <= ?");
  $stmt1->bind_param('si', $category, $price);
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();

  // Products per page
  $total_records_per_page = 12;
  $offset = ($page_no - 1) * $total_records_per_page;

  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  // Get all products
  $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category = ? AND product_price <= ? LIMIT $offset, $total_records_per_page");
  $stmt2->bind_param('si', $category, $price);
  $stmt2->execute();
  $products = $stmt2->get_result();
} else {
  // Determine the page number
  $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

  // Return number of products
  $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
  $stmt1->execute();
  $stmt1->bind_result($total_records);
  $stmt1->store_result();
  $stmt1->fetch();

  // Products per page
  $total_records_per_page = 12;
  $offset = ($page_no - 1) * $total_records_per_page;

  $total_no_of_pages = ceil($total_records / $total_records_per_page);

  // Get all products
  $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
  $stmt2->execute();
  $products = $stmt2->get_result();
}
?>

<style>
  /* Premium Styling */
  body {
  font-family: 'Poppins', sans-serif;
  background-color: #f4f4f9;
  color: #333;
  }

  .product img {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-radius: 10px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .product img:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  .pagination a {
  color: #fff;
  background-color: #007bff;
  border-radius: 5px;
  padding: 8px 12px;
  margin: 0 5px;
  text-decoration: none;
  transition: background-color 0.3s ease;
  }

  .pagination a:hover {
  background-color: #0056b3;
  }

  .pagination .disabled a {
  background-color: #ccc;
  pointer-events: none;
  }

  #search {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  #search p {
  font-weight: bold;
  color: #007bff;
  }

  #shop .product {
  background-color: #fff;
  border-radius: 10px;
  padding: 15px;
  margin: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  #shop .product:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }

  .btn-primary {
  background-color: #007bff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
  background-color: #0056b3;
  }

  .star i {
  color: #ffc107;
  }

  @media (max-width: 768px) {
  #shop .product {
    width: calc(50% - 20px);
  }
  }

  @media (max-width: 576px) {
  #shop .product {
    width: 100%;
  }
  }
</style>

<!-- Search Section -->
<section id="search" class="my-5 py-5">
  <div class="container">
  <h3 class="text-center">Search Products</h3>
  <hr class="mx-auto">
  <form action="shop.php" method="POST">
    <div class="form-group">
    <label for="category">Category</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="category" value="nike" id="nike" <?php if (isset($category) && $category == 'nike') echo 'checked'; ?>>
      <label class="form-check-label" for="nike">Nike</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="category" value="puma" id="puma" <?php if (isset($category) && $category == 'puma') echo 'checked'; ?>>
      <label class="form-check-label" for="puma">Puma</label>
    </div>
    <!-- Add more categories as needed -->
    </div>
    <div class="form-group">
    <label for="price">Price</label>
    <input type="range" class="form-range" name="price" min="1" max="10000" value="<?php echo isset($price) ? $price : 100; ?>">
    <div class="d-flex justify-content-between">
      <span>1</span>
      <span>10000</span>
    </div>
    </div>
    <button type="submit" name="search" class="btn btn-primary w-100">Search</button>
  </form>
  </div>
</section>

<!-- Shop Section -->
<section id="shop" class="my-5 py-5">
  <div class="container text-center">
  <h3>Our Products</h3>
  <hr class="mx-auto">
  <p>Explore our premium collection of shoes</p>
  </div>
  <div class="row">
  <?php while ($row = $products->fetch_assoc()) { ?>
    <div class="product col-lg-3 col-md-4 col-sm-6">
    <img src="./assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
    <div class="star">
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
    </div>
    <h5><?php echo $row['product_name']; ?></h5>
    <h4>Rs. <?php echo $row['product_price']; ?></h4>
    <a href="single_product.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-primary">Buy Now</a>
    </div>
  <?php } ?>
  </div>
  <!-- Pagination -->
  <nav class="mt-5">
  <ul class="pagination justify-content-center">
    <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
    <a class="page-link" href="<?php if ($page_no > 1) echo "?page_no=" . ($page_no - 1); ?>">Previous</a>
    </li>
    <?php for ($i = 1; $i <= $total_no_of_pages; $i++) { ?>
    <li class="page-item <?php if ($page_no == $i) echo 'active'; ?>">
      <a class="page-link" href="?page_no=<?php echo $i; ?>"><?php echo $i; ?></a>
    </li>
    <?php } ?>
    <li class="page-item <?php if ($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
    <a class="page-link" href="<?php if ($page_no < $total_no_of_pages) echo "?page_no=" . ($page_no + 1); ?>">Next</a>
    </li>
  </ul>
  </nav>
</section>

<?php include('layouts/footer.php'); ?>
