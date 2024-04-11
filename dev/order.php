<?php

@include_once(__DIR__ . '/src/Helpers/Auth.php');
@include_once(__DIR__ . '/src/Helpers/Message.php');
@include_once(__DIR__ . '/src/Database/Database.php');

@include_once(__DIR__ . '/template/head.inc.php');

if (guest()) {
   if (!headers_sent()) {
      setMessage('login-messages', 'De winkelwagen is alleen te zien indien u bent ingelogd. Log a.u.b. in...');
      header('Location: ./login.php');
      exit();
   } else {
      die('Pagina kan niet getoond worden als u niet bent ingelogd');
   }
}

Database::query("SELECT 
      `cart_items`.`id`, 
      `cart_items`.`cart_id`, 
      `cart_items`.`product_id`, 
      `cart_items`.`amount`,
      `cart`.`customer_id`,
      `products`.`category_id`,
      `products`.`name`,
      `products`.`description`,
      `products`.`price`,
      `products`.`image`,
     (`cart_items`.`amount` * `products`.`price`) AS `product_total`
   FROM `cart_items`
   LEFT JOIN `products` ON `products`.`id` = `cart_items`.`product_id`
   LEFT JOIN `cart` ON `cart`.`id` = `cart_items`.`cart_id`
   WHERE `cart`.`customer_id` = :customer_id AND `cart`.`ordered` = 0", [":customer_id" => user_id()]);

$cart_items = Database::getAll();
$cart_total_amount = 0;
$cart_total_cost = 0.0;
$shipping_cost = 0.0;

$customer_fullname = user()->firstname . (!empty(user()->prefixes) ? " " . user()->prefixes : "") . " " . user()->lastname;

foreach ($cart_items as $cart_item) {
   $cart_total_amount += intval($cart_item->amount);
   $cart_total_cost += floatval($cart_item->product_total);
}
$order_total = $cart_total_cost + $shipping_cost;
?>

<div class="uk-grid">
   <!-- BEGIN: FACTUUR -->
   <section class="uk-width-1-3">
      <div class="uk-card-default uk-card-small uk-flex uk-flex-column uk-padding-small uk-flex-1">
         <div class="uk-card-header">
            <h2>Factuur</h2>
         </div>
         <!-- INVULLEN MET PHP -->
         <div class="uk-card-body uk-flex uk-flex-column uk-flex-between">
            <div class="uk-flex uk-flex-between uk-flex-center">
               <p class="uk-width-1-2">Artikelen (<?= $cart_total_amount ?>)</p>
               <p class="uk-width-1-2 uk-margin-remove-top uk-text-right">&euro; <?= sprintf("%.2f", $cart_total_cost) ?></p>
            </div>
            <div class="uk-flex uk-flex-between uk-flex-center">
               <p class="uk-width-1-2">Verzendkosten</p>
               <p class="uk-width-1-2 uk-margin-remove-top uk-text-right">&euro; <?= sprintf("%.2f", $shipping_cost) ?></p>
            </div>
         </div>
         <div class="uk-card-footer">
            <div class="uk-flex uk-flex-between uk-flex-center">
               <p class="uk-width-1-2 uk-text-bold">Te betalen</p>
               <p class="uk-width-1-2 uk-margin-remove-top uk-text-right uk-text-bold">&euro; <?= sprintf("%.2f", $order_total) ?></p>
            </div>
         </div>
         <!-- EIND INVULLEN MET PHP -->
      </div>
   </section>
   <!-- EINDE: FACTUUR -->

   <!-- BEGIN: VERZENDADRES -->
   <section class="uk-width-1-3">
      <div class="uk-card-default uk-card-small uk-flex uk-flex uk-flex-column uk-flex-between uk-padding-small  uk-flex-1">
         <div class="uk-card-header">
            <h2>Verzendadres</h2>
         </div>
         <!-- ADRES INGELOGDE USER -->
         <div class="uk-card-body uk-flex uk-flex-column uk-flex-between">
            <p class="uk-margin-remove-vertical"><?= $customer_fullname ?></p>
            <p class="uk-margin-remove-vertical"><?= user()->street ?> <?= user()->house_number ?><?= !empty(user()->addition) ? user()->addition : "" ?></p>
            <p class="uk-margin-remove-vertical"><?= user()->zipcode ?> <?= user()->city ?></p>
         </div>
         <div class="uk-card-footer">
            <div class="uk-flex uk-flex-1 uk-flex-middle uk-flex-center uk-margin-medium-top">
               <button class="uk-button uk-button-default">
                  Wijzigen
               </button>
            </div>
         </div>
      </div>
   </section>
   <!-- EINDE: VERZENDADRES -->

   <!-- BEGIN: BETALEN -->
   <section class="uk-width-1-3">
      <div class="uk-card-default uk-card-small uk-flex uk-flex uk-flex-column uk-flex-between uk-padding-small uk-flex-1">
         <div class="uk-card-header">
            <h2>Betalen</h2>
         </div>
         <div class="uk-card-body uk-flex uk-flex-column uk-flex-between">
            <div class="uk-flex uk-flex-between uk-gap">
               <img src="img/IDEAL.png" class="" alt="" title="" />
               <select name="bank">
                  <option>Kies uw bank</option>
                  <option value="1">Rabobank</option>
                  <option value="1">ASN Bank</option>
                  <option value="1">ING Bank</option>
                  <option value="1">Regiobank</option>
                  <option value="1">SNS Bank</option>
                  <option value="1">ABNAMRO Bank</option>
               </select>
            </div>
         </div>
         <div class="uk-card-footer">
            <div class="uk-flex uk-flex-1 uk-flex-middle uk-flex-center uk-margin-medium-top">
               <a href="order_confirm.php" class="uk-button uk-button-primary">
                  Betalen
               </a>
            </div>
         </div>
      </div>
   </section>
   <!-- EINDE: BETALEN -->
</div>

<?php
@include_once(__DIR__ . '/template/foot.inc.php');
