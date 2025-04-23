<?php

include('connection.php');

$stmt = $conn -> prepare("SELECT * FROM products where product_category='party' LIMIT 4" );

$stmt -> execute();

$party_products = $stmt->get_result();

?>