<?php include('layouts/header.php'); ?>
<?php

/*
    not paid
    shipped
    Delivered
*/ 
include('server/connection.php');

if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");

    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    $order_details = $stmt->get_result();

    $order_total_price = calculateTotalOrderPrice($order_details);

} else {

    header('location:account.php');
    exit;
}

function calculateTotalOrderPrice($order_details)
{
    $total = 0;
    foreach ($order_details as $row) { 
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        $total += $product_price * $product_quantity;
    }
    return $total;
}

?>

<!-- Order Details -->
<section id="orders" class="cart container my-5 py-3">
    <div class="container mt-5">
        <h2 class="font-weight-bold text-center text-primary">Order Details</h2>
        <hr class="mx-auto" style="width: 50%; border-top: 2px solid #007bff;" />
    </div>

    <div class="table-responsive mt-5">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_details as $row) { ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="assets/imgs/<?php echo $row['product_image']; ?>" alt="Product Image" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="ml-3">
                                    <p class="mb-0 font-weight-bold"><?php echo $row['product_name']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-success font-weight-bold">Rs. <?php echo $row['product_price']; ?></span>
                        </td>
                        <td>
                            <span class="badge badge-primary p-2"><?php echo $row['product_quantity']; ?></span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="text-right mt-4">
        <h4 class="font-weight-bold">Total Price: <span class="text-success">Rs. <?php echo $order_total_price; ?></span></h4>
    </div>

    <?php if ($order_status == "not paid") { ?>
        <div class="text-right mt-3">
            <form method="POST" action="payment.php">
                <input type="hidden" name="order_total_price" value="<?php echo $order_total_price; ?>">
                <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
                <button type="submit" name="order_pay_btn" class="btn btn-lg btn-primary">Pay Now</button>
            </form>
        </div>
    <?php } ?>
</section>

<!-- Footer -->
<?php include('layouts/footer.php') ?>
