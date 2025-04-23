<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products where product_category='featured' LIMIT 4");

$stmt->execute();

$featured_products = $stmt->get_result();

?>