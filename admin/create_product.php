<?php

include 'header.php';
include '../server/connection.php';

// Function to validate input
function validateInput($data, $errorRedirect, $errorMessage) {
    if ($data) {
        return $data;
    }
    header("location:$errorRedirect?error=$errorMessage");
    exit;
}

// Function to validate and upload images
function uploadImage($image, $imageName, $uploadDir = "../assets/imgs/") {
    if ($image) {
        $destination = $uploadDir . $imageName;
        move_uploaded_file($image, $destination);
        return $imageName;
    }
    return null;
}

if (isset($_POST['create_product'])) {
    // Sanitize and validate inputs
    $product_name = validateInput(
        $_POST['name'],
        'add_product.php',
        'Title is invalid, Use Proper Title'
    );
    if (!preg_match('/^(?=.*[a-zA-Z])[a-zA-Z0-9\s\-\' ]+$/', $product_name)) {
        header('location:add_product.php?error=Title is invalid, Use Proper Title');
        exit;
    }

    $product_description = validateInput(
        $_POST['description'],
        'add_product.php',
        'Description must contain at least 20 words'
    );
    if (str_word_count($product_description) < 20) {
        header('location:add_product.php?error=Description must contain at least 20 words');
        exit;
    }

    $product_price = validateInput(
        $_POST['price'],
        'add_product.php',
        'Price must be a positive number'
    );
    if (!is_numeric($product_price) || $product_price <= 0) {
        header('location:add_product.php?error=Price must be a positive number');
        exit;
    }

    $product_special_offer = validateInput(
        $_POST['offer'],
        'add_product.php',
        'Offer must be a number between 0 and 100'
    );
    if (!is_numeric($product_special_offer) || $product_special_offer < 0 || $product_special_offer > 100) {
        header('location:add_product.php?error=Offer must be a number between 0 and 100');
        exit;
    }

    $allowed_categories = ['exclusive', 'featured', 'party', 'nike', 'adidas', 'puma'];
    $product_category = validateInput(
        $_POST['category'],
        'add_product.php',
        'Invalid category selected'
    );
    if (!in_array($product_category, $allowed_categories)) {
        header('location:add_product.php?error=Invalid category selected');
        exit;
    }

    $allowed_colors = ['aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blue', 'red', 'yellow', 'green', 'white', 'gray'];
    $product_color = validateInput(
        $_POST['color'],
        'add_product.php',
        'Color is invalid'
    );
    if (!in_array(strtolower($product_color), $allowed_colors)) {
        header('location:add_product.php?error=Color is invalid');
        exit;
    }

    // Handle image uploads
    $image1 = uploadImage($_FILES['image1']['tmp_name'], $product_name . "1.jpeg");
    $image2 = uploadImage($_FILES['image2']['tmp_name'], $product_name . "2.jpeg");
    $image3 = uploadImage($_FILES['image3']['tmp_name'], $product_name . "3.jpeg");
    $image4 = uploadImage($_FILES['image4']['tmp_name'], $product_name . "4.jpeg");

    // Insert product into the database
    $stmt = $conn->prepare(
        "INSERT INTO products (product_name, product_description, product_price, product_special_offer, 
        product_image, product_image2, product_image3, product_image4, product_category, product_color) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        'ssssssssss',
        $product_name,
        $product_description,
        $product_price,
        $product_special_offer,
        $image1,
        $image2,
        $image3,
        $image4,
        $product_category,
        $product_color
    );

    if ($stmt->execute()) {
        header('location: products.php?product_created=Product added Successfully');
    } else {
        header('location: products.php?product_failed=Error occurred, try again');
    }
}
