<?php

include('connection.php');

$stmt = $conn -> prepare("SELECT * FROM products where product_category='adidas' LIMIT 4" );

$stmt -> execute();

$adidas = $stmt->get_result();

?>