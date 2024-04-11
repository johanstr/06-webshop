<?php

@include_once(__DIR__.'/../Helpers/Auth.php');
@include_once(__DIR__.'/../Helpers/Message.php');
@include_once(__DIR__.'/../Database/Database.php');

date_default_timezone_set('Europe/Amsterdam');

// CHECK 1 - CHECK Request type
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isLoggedIn()) {
   // Geen POST-request dus stoppen we
   // We keren terug naar de login pagina
   setError('addtocart-error', 'Log a.u.b. in om een bestelling te kunnen doen, nog geen account registreer dan eerst a.u.b.');
   header('Location: ' . getLastVisitedPage());
   exit();
}

// CHECK 2 - CHECK benodigde gegevens
if (!isset($_POST['product_id'])) {
   // Informatie ontbreekt, dus terug naar product pagina
   setError('no-product-error', 'ID van het product ontbreekt');

   header('Location: ' . getLastVisitedPage());
   exit();
}

/**
 * Checken of er al een winkelwagen is voor de ingelogde user
 */
Database::query("SELECT `cart`.`id` FROM `cart` WHERE `cart`.`customer_id` = :id AND `cart`.`ordered` = 0", [
   ':id' => user_id()
]);
$cart = Database::get();
$cart_id = 0;
$product_id = intval($_POST['product_id']);
if(empty($cart) || is_null($cart)) {
   // Bestaat nog niet, dus we maken een nieuwe aan
   Database::query("INSERT INTO `cart`(`cart`.`customer_id`) VALUES(:id)", [
      ':id' => user_id()
   ]);
   $cart_id = Database::lastInserted();
} else {
   $cart_id = $cart->id;
}

/**
 * Checken of het product al in de winkelwagen zit
 * Zo ja, verhoog het aantal met 1
 * Zo nee, voeg toe en zet aantal op 1
 */
Database::query("SELECT * FROM `cart_items` WHERE `cart_items`.`cart_id` = :cart_id AND `cart_items`.`product_id` = :product_id",
[
   ':cart_id' => $cart_id,
   ':product_id' => $product_id
]);
$cart_item = Database::get();

if(empty($cart_item) || is_null($cart_item)) {
   // Product zit nog niet in de winkelwagen, dus toevoegen
   Database::query(
      "INSERT INTO `cart_items`(`cart_items`.`cart_id`, `cart_items`.`product_id`, `cart_items`.`amount`)
      VALUES(:cart_id, :product_id, :amount)",[
         ':cart_id' => $cart_id,
         ':product_id' => $product_id,
         ':amount' => 1
      ]);
      setMessage('product-added', "Product is toegevoegd aan de winkelwagen");
} else {
   // Product zit al in de winkelwagen, dus aantal verhogen
   Database::query("UPDATE `cart_items` SET `cart_items`.`amount` = :amount", [
      ':amount' => $cart_item->amount + 1
   ]);
   setMessage('product-amount-increased', "Aantal van dit product in de winkelwagen verhoogd met 1");
}

// Terugkeren naar de vorige pagina
if(!headers_sent()) {
   header('Location: ' . getLastVisitedPage());
   exit();
}