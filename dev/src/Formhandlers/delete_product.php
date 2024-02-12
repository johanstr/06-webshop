<?php

@include_once(__DIR__ . '/../Helpers/Auth.php');
@include_once(__DIR__ . '/../Database/Database.php');

if (guest() || $_SERVER['REQUEST_METHOD'] != 'POST') {
   http_response_code(401);
   die('Geen toegang...');
}

$cart_id = $_POST['cart_id'];
$product_id = $_POST['product_id'];

Database::query(
   "DELETE FROM `cart_items` 
    WHERE `cart_items`.`cart_id` = :cart_id AND `cart_items`.`product_id` = :product_id",
   [
      ':product_id' => $product_id,
      ':cart_id' => $cart_id
   ]
);

header('Location: ../../cart.php');
