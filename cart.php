<?php include('layouts/header.php'); ?>
<?php

if (isset($_POST['add_to_cart'])) {
  if (isset($_SESSION['cart'])) {
    $products_array_ids = array_column($_SESSION['cart'], "product_id");
    if (!in_array($_POST['product_id'], $products_array_ids)) {
      $product_id = $_POST['product_id'];
      $product_array = array(
        'product_id' => $_POST['product_id'],
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'product_image' => $_POST['product_image'],
        'product_quantity' => $_POST['product_quantity']
      );
      $_SESSION['cart'][$product_id] = $product_array;
    } else {
      echo '<script>alert("Product was already added to the cart");</script>';
    }
  } else {
    $product_id = $_POST['product_id'];
    $product_array = array(
      'product_id' => $product_id,
      'product_name' => $_POST['product_name'],
      'product_price' => $_POST['product_price'],
      'product_image' => $_POST['product_image'],
      'product_quantity' => $_POST['product_quantity']
    );
    $_SESSION['cart'][$product_id] = $product_array;
  }
  calculateTotalCart();
} else if (isset($_POST['remove_product'])) {
  $product_id = $_POST['product_id'];
  unset($_SESSION['cart'][$product_id]);
  calculateTotalCart();
} else if (isset($_POST['edit_quantity'])) {
  $product_id = $_POST['product_id'];
  $product_quantity = $_POST['product_quantity'];
  $product_array = $_SESSION['cart'][$product_id];
  $product_array['product_quantity'] = $product_quantity;
  $_SESSION['cart'][$product_id] = $product_array;
  calculateTotalCart();
}

function calculateTotalCart()
{
  $total_price = 0;
  $total_quantity = 0;
  foreach ($_SESSION['cart'] as $key => $value) {
    $product = $_SESSION['cart'][$key];
    $price = $product['product_price'];
    $quantity = $product['product_quantity'];
    $total_price += $price * $quantity;
    $total_quantity += $quantity;
  }
  $_SESSION['total'] = $total_price;
  $_SESSION['quantity'] = $total_quantity;
}

?>

<!--Cart-->
<section class="cart container my-5 py-5">
  <div class="container mt-5 text-center">
    <h2 class="font-weight-bold text-uppercase">Your Premium Cart</h2>
    <hr class="mx-auto">
  </div>
  <table class="table table-hover mt-5">
    <thead class="thead-dark">
      <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($_SESSION['cart'])) { ?>
        <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
          <tr>
            <td>
              <div class="product-info d-flex align-items-center">
                <img src="assets/imgs/<?php echo $value['product_image']; ?>" alt="Product Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                <div class="ml-3">
                  <p class="font-weight-bold"><?php echo $value['product_name']; ?></p>
                  <small class="text-muted">Rs. <?php echo $value['product_price']; ?></small>
                </div>
              </div>
            </td>
            <td>
              <form method="POST" action="cart.php" class="d-flex align-items-center">
                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" class="form-control w-50">
                <button type="submit" class="btn btn-primary btn-sm ml-2" name="edit_quantity">Update</button>
              </form>
            </td>
            <td>Rs. <?php echo $value['product_quantity'] * $value['product_price']; ?></td>
            <td>
              <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                <button type="submit" name="remove_product" class="btn btn-danger btn-sm">Remove</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="4" class="text-center">Your cart is empty.</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <div class="cart-total text-right mt-4">
    <h4>Total: Rs. <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : '0'; ?></h4>
  </div>

  <div class="checkout-container text-right mt-3">
    <form method="POST" action="checkout.php">
      <button type="submit" class="btn btn-success btn-lg" name="Checkout">Proceed to Checkout</button>
    </form>
  </div>
</section>

<!--Footer-->
<?php include('layouts/footer.php'); ?>
