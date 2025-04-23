<?php include('header.php'); ?>

<?php 
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $products = $stmt->get_result();
    } elseif (isset($_POST['edit_btn'])) {
        $product_id = $_POST['product_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $offer = $_POST['offer'];
        $color = $_POST['color'];
        $category = $_POST['category'];

        $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_description = ?, product_price = ?, product_special_offer = ?, product_color = ?, product_category = ? WHERE product_id = ?");
        $stmt->bind_param('ssssssi', $title, $description, $price, $offer, $color, $category, $product_id);

        if ($stmt->execute()) {
            header('location:products.php?edit_success_message=Product has been updated successfully');
        } else {
            header('location:products.php?edit_failure_message=Error occurred, Try again');
        }
    } else {
        header('location:products.php');
        exit;
    }
?>

<div class="container-fluid">
    <div class="row" style="min-height:1000px">
        <?php include('sidemenu.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Product</h1>
            </div>

            <div class="card shadow-sm p-4">
                <h2 class="text-center mb-4">Edit Product Details</h2>
                <form id="edit-form" method="POST" action="edit_product.php">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_GET['error']; ?>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($products as $product): ?>
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                        <div class="mb-3">
                            <label for="product-name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="product-name" name="title" value="<?php echo $product['product_name']; ?>" placeholder="Enter product title" required>
                        </div>

                        <div class="mb-3">
                            <label for="product-desc" class="form-label">Description</label>
                            <textarea class="form-control" id="product-desc" name="description" rows="3" placeholder="Enter product description" required><?php echo $product['product_description']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="product-price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="product-price" name="price" value="<?php echo $product['product_price']; ?>" placeholder="Enter product price" required>
                        </div>

                        <div class="mb-3">
                            <label for="product-category" class="form-label">Category</label>
                            <select class="form-select" id="product-category" name="category" required>
                                <option value="exclusive" <?php echo $product['product_category'] == 'exclusive' ? 'selected' : ''; ?>>Exclusive</option>
                                <option value="featured" <?php echo $product['product_category'] == 'featured' ? 'selected' : ''; ?>>Featured</option>
                                <option value="party" <?php echo $product['product_category'] == 'party' ? 'selected' : ''; ?>>Party</option>
                                <option value="nike" <?php echo $product['product_category'] == 'nike' ? 'selected' : ''; ?>>Nike</option>
                                <option value="adidas" <?php echo $product['product_category'] == 'adidas' ? 'selected' : ''; ?>>Adidas</option>
                                <option value="puma" <?php echo $product['product_category'] == 'puma' ? 'selected' : ''; ?>>Puma</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="product-color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="product-color" name="color" value="<?php echo $product['product_color']; ?>" placeholder="Enter product color" required>
                        </div>

                        <div class="mb-3">
                            <label for="product-offer" class="form-label">Special Offer/Sale</label>
                            <input type="number" class="form-control" id="product-offer" name="offer" value="<?php echo $product['product_special_offer']; ?>" placeholder="Enter sale percentage" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="edit_btn" class="btn btn-primary btn-lg">Update Product</button>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.2/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
