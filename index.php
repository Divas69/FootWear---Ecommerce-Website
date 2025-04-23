<?php include('layouts/header.php'); ?>

<!-- Home Section -->
<section id="home" class="hero-section">
  <div class="container text-center">
    <h5 class="text-uppercase text-primary">New Arrivals</h5>
    <h1 class="display-4"><span class="text-highlight">Best Prices</span> This Season</h1>
    <p class="lead text-muted">
      Discover premium quality shoes at unbeatable prices only at ShoeSphere.
    </p>
    <a href="shop.php" class="btn btn-primary btn-lg mt-3">Shop Now</a>
  </div>
</section>

<!-- Brands Section -->
<section id="brand" class="container py-5">
  <div class="row text-center">
    <div class="col-lg-3 col-md-6 col-sm-12">
      <img class="img-fluid brand-logo" src="./assets/imgs/reebok.png" alt="Reebok Logo" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
      <img class="img-fluid brand-logo" src="./assets/imgs/nike.jpg" alt="Nike Logo" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
      <img class="img-fluid brand-logo" src="./assets/imgs/Adidas_logo.png" alt="Adidas Logo" />
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
      <img class="img-fluid brand-logo" src="./assets/imgs/puma.jpg" alt="Puma Logo" />
    </div>
  </div>
</section>

<!-- New Arrivals Section -->
<section id="new" class="w-100 py-5 bg-light">
  <div class="row p-0 m-0">
    <!-- Product Card -->
    <div class="col-lg-4 col-md-6 col-sm-12 p-0">
      <div class="card border-0">
        <img class="card-img-top" src="./assets/imgs/new-2.jpg" alt="Nike Shoes">
        <div class="card-body text-center">
          <h5 class="card-title">Awesome Nike Shoes</h5>
          <a href="shop.php" class="btn btn-outline-primary">Shop Now</a>
        </div>
      </div>
    </div>
    <!-- Product Card -->
    <div class="col-lg-4 col-md-6 col-sm-12 p-0">
      <div class="card border-0">
        <img class="card-img-top" src="./assets/imgs/new-1.avif" alt="Adidas Shoes">
        <div class="card-body text-center">
          <h5 class="card-title">Awesome Adidas Shoes</h5>
          <a href="shop.php" class="btn btn-outline-primary">Shop Now</a>
        </div>
      </div>
    </div>
    <!-- Product Card -->
    <div class="col-lg-4 col-md-6 col-sm-12 p-0">
      <div class="card border-0">
        <img class="card-img-top" src="./assets/imgs/new-3.jpg" alt="Reebok Shoes">
        <div class="card-body text-center">
          <h5 class="card-title">Awesome Reebok Shoes</h5>
          <a href="shop.php" class="btn btn-outline-primary">Shop Now</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Section -->
<section id="featured" class="my-5">
  <div class="container text-center">
    <h3 class="section-title">Our Featured Products</h3>
    <hr class="mx-auto mb-4" />
    <p class="text-muted">Explore our exclusive collection of featured shoes.</p>
  </div>
  <div class="row mx-auto container-fluid">
    <?php include('server/get_featured_products.php'); ?>
    <?php while ($row = $featured_products->fetch_assoc()) { ?>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <div class="card border-0 shadow-sm">
          <img class="card-img-top" src="./assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
            <p class="card-text text-primary">Rs.<?php echo $row['product_price']; ?></p>
            <a href="<?php echo "single_product.php?product_id=" . $row['product_id']; ?>" class="btn btn-primary">Buy Now</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<!-- Banner Section -->
<section id="banner" class="my-5 py-5 bg-dark text-white text-center">
  <div class="container">
    <h4 class="text-uppercase">Mid Season Sale</h4>
    <h1 class="display-4">Autumn Collection <br> Up to 30% Off</h1>
    <a href="shop.php" class="btn btn-light btn-lg mt-3">Shop Now</a>
  </div>
</section>

<!-- Exclusive Sections -->
<?php
$brands = ['Puma', 'Adidas', 'Nike'];
foreach ($brands as $brand) {
  $brand_lower = strtolower($brand);
  ?>
  <section id="featured" class="my-5">
    <div class="container text-center">
      <h3 class="section-title"><?php echo $brand; ?></h3>
      <hr class="mx-auto mb-4" />
      <p class="text-muted">Discover our premium <?php echo $brand; ?> collection.</p>
    </div>
    <div class="row mx-auto container-fluid">
      <?php include("server/get_$brand_lower.php"); ?>
      <?php while ($row = ${$brand_lower}->fetch_assoc()) { ?>
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <div class="card border-0 shadow-sm">
            <img class="card-img-top" src="./assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
              <p class="card-text text-primary">Rs.<?php echo $row['product_price']; ?></p>
              <a href="<?php echo "single_product.php?product_id=" . $row['product_id']; ?>" class="btn btn-primary">Buy Now</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>
<?php } ?>

<?php include('layouts/footer.php'); ?>
