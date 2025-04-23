<?php include('layouts/header.php'); ?>

<?php
if (isset($_POST['order_pay_btn'])) {
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];
}
?>

<!-- Payment Section -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold display-4 text-primary">Secure Payment</h2>
        <p class="text-muted">Complete your payment securely and effortlessly</p>
        <hr class="mx-auto w-50">
    </div>
    <div class="mx-auto container text-center p-4 shadow-lg rounded bg-light" style="max-width: 500px;">
        <?php if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
            <p class="h4 text-success">Total Payment: <strong>Rs.<?php echo $_SESSION['total']; ?></strong></p>
            <button class="btn btn-primary btn-lg mt-3 px-5">Pay Now</button>
        <?php } else if (isset($_POST['order_status']) && $_POST['order_status'] == "not paid") { ?>
            <p class="h4 text-warning">Total Payment: <strong>Rs.<?php echo $_POST['order_total_price']; ?></strong></p>
            <button class="btn btn-primary btn-lg mt-3 px-5">Pay Now</button>
        <?php } else { ?>
            <p class="h4 text-danger">You don't have an order</p>
        <?php } ?>
    </div>
</section>

<!-- Footer -->
<?php include('layouts/footer.php'); ?>
