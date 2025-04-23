<?php

include('connection.php');

$stmt = $conn -> prepare("SELECT * FROM products where product_category='exclusive' LIMIT 4" );

$stmt -> execute();

$exclusives_products = $stmt->get_result();

?>