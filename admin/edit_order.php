<?php include('header.php'); ?>

<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order = $stmt->get_result();
} elseif (isset($_POST['edit_order'])) {
    $order_status = $_POST['order_status'];
    $order_id = $_POST['order_id'];

    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param('si', $order_status, $order_id);
    if ($stmt->execute()) {
        header('location:index.php?order_updated=Product has been updated successfully');
    } else {
        header('location:index.php?order_failed=Error occurred, Try again');
    }
} else {
    header('location:index.php');
    exit;
}
?>

<div class="container-fluid">
    <div class="row" style="min-height: 1000px;">
        <?php include('sidemenu.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Order</h1>
            </div>

            <div class="card shadow-sm p-4">
                <h2 class="text-center mb-4">Edit Order Details</h2>
                <div class="mx-auto container">
                    <form id="edit-order-form" method="POST" action="edit_order.php">
                        <?php foreach ($order as $r) { ?>
                            <?php if (isset($_GET['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $_GET['error']; ?>
                                </div>
                            <?php } ?>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Order ID</label>
                                <p class="form-control-plaintext"><?php echo $r['order_id']; ?></p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Order Price</label>
                                <p class="form-control-plaintext">$<?php echo number_format($r['order_cost'], 2); ?></p>
                            </div>

                            <input type="hidden" name="order_id" value="<?php echo $r['order_id']; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Order Status</label>
                                <select class="form-select" required name="order_status">
                                    <option value="not paid" <?php if ($r['order_status'] == 'not paid') echo "selected"; ?>>Not Paid</option>
                                    <option value="paid" <?php if ($r['order_status'] == 'paid') echo "selected"; ?>>Paid</option>
                                    <option value="shipped" <?php if ($r['order_status'] == 'shipped') echo "selected"; ?>>Shipped</option>
                                    <option value="delivered" <?php if ($r['order_status'] == 'delivered') echo "selected"; ?>>Delivered</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Order Date</label>
                                <p class="form-control-plaintext"><?php echo date('F j, Y', strtotime($r['order_date'])); ?></p>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="edit_order" class="btn btn-primary btn-lg">Update Order</button>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
