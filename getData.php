<?php

include_once 'connection.php';



$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);


$products_json = array();

while ($row = mysqli_fetch_assoc($result)) {
  $products_json[] = $row;
}

echo json_encode($products_json);




?>