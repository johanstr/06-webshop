<?php

@include_once(__DIR__ . '/../Helpers/Auth.php');
@include_once(__DIR__ . '/../Database/Database.php');

if (guest() || $_SERVER['REQUEST_METHOD'] != 'POST') {
   http_response_code(401);
   die('Geen toegang...');
}

$cart_id = $_POST['cart_id'];
$product_id = $_POST['product_id'];
$amount = $_POST['amount'];

Database::query("UPDATE `cart_items` 
               SET `cart_items`.`amount` = :amount 
               WHERE `cart_items`.`cart_id` = :cart_id AND `cart_items`.`product_id` = :product_id",
               [
                  ':amount' => $amount,
                  ':product_id' => $product_id,
                  ':cart_id' => $cart_id
               ]
);

header('Location: ../../cart.php');
