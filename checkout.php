<?php include('layouts/header.php'); ?>
<?php

// Let user in
if (!empty($_SESSION['cart'])) {
    // User can proceed
} else {
    header('location:index.php');
}

?>

<!-- CheckOut -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold display-4 text-primary">Checkout</h2>
        <p class="lead text-muted">Complete your order by filling out the details below</p>
        <hr class="mx-auto w-50">
    </div>
    <div class="mx-auto container shadow-lg p-5 bg-white rounded">
        <form id="checkout-form" method="POST" action="server/place_order.php">
            <p class="text-center text-danger">
                <?php if (isset($_GET['message'])) { echo $_GET['message']; } ?>
                <?php if (isset($_GET['message'])) { ?>
                    <a href="login.php" class="btn btn-primary mt-2">Login</a>
                <?php } ?>
            </p>

            <div class="form-group">
                <label for="name" class="font-weight-bold">Name</label>
                <input type="text" class="form-control border-primary" id="checkout-name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="tel" class="font-weight-bold">Phone</label>
                <input type="tel" class="form-control border-primary" id="checkout-phone" name="phone" placeholder="Enter your phone number" required>
            </div>

            <div class="form-group">
                <label for="city" class="font-weight-bold">City</label>
                <input type="text" class="form-control border-primary" id="checkout-city" name="city" placeholder="Enter your city" required>
            </div>

            <div class="form-group">
                <label for="address" class="font-weight-bold">Address</label>
                <input type="text" class="form-control border-primary" id="checkout-address" name="address" placeholder="Enter your address" required>
            </div>

            <div class="form-group text-center">
                <p class="font-weight-bold text-success">Total Amount: Rs. <?php echo $_SESSION['total']; ?></p>
                <input type="submit" class="btn btn-success btn-lg px-5" id="checkout-btn" name="place_order" value="Place Order">
            </div>
        </form>
    </div>
</section>

<!-- Footer -->
<?php include('layouts/footer.php'); ?>

<script>
    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        var name = document.getElementById('checkout-name').value;
        var namePattern = /^[a-zA-Z\s]+$/;
        if (!namePattern.test(name)) {
            alert('Name cannot contain numbers or special characters.');
            event.preventDefault();
        }

        var phone = document.getElementById('checkout-phone').value;
        var phonePattern = /^[0-9]+$/;
        if (!phonePattern.test(phone)) {
            alert('Phone number cannot contain alphabets or special characters.');
            event.preventDefault();
        }
    });
</script>
