<?php
// Include database connection
include('../server/connection.php');

// Check if the form is submitted
if (isset($_POST['update_images'])) {
    // Retrieve form data
    $product_name = $_POST['product_name'];
    $product_id = $_POST['product_id'];

    // File upload paths
    $upload_dir = "../assets/imgs/";
    $image_names = [
        $product_name . "1.jpeg",
        $product_name . "2.jpeg",
        $product_name . "3.jpeg",
        $product_name . "4.jpeg"
    ];

    // Temporary file paths
    $tmp_files = [
        $_FILES['image1']['tmp_name'],
        $_FILES['image2']['tmp_name'],
        $_FILES['image3']['tmp_name'],
        $_FILES['image4']['tmp_name']
    ];

    // Upload images and validate
    foreach ($tmp_files as $index => $tmp_file) {
        if (!empty($tmp_file)) {
            if (!move_uploaded_file($tmp_file, $upload_dir . $image_names[$index])) {
                header('location: products.php?images_failed=Failed to upload image ' . ($index + 1));
                exit();
            }
        }
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("
        UPDATE products 
        SET product_image = ?, product_image2 = ?, product_image3 = ?, product_image4 = ? 
        WHERE product_id = ?
    ");

    // Bind parameters
    $stmt->bind_param('ssssi', $image_names[0], $image_names[1], $image_names[2], $image_names[3], $product_id);

    // Execute and handle result
    if ($stmt->execute()) {
        header('location: products.php?images_updated=Images updated successfully');
    } else {
        header('location: products.php?images_failed=Error occurred, try again');
    }
}
?>