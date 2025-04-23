<?php

include('connection.php');

$stmt = $conn -> prepare("SELECT * FROM products where product_category='puma' LIMIT 4" );

$stmt -> execute();

$puma = $stmt->get_result();

?>