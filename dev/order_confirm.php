<?php
date_default_timezone_set('Europe/Amsterdam');

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

// Simulatie dat de order betaald is en afgerond
Database::query("UPDATE `cart` SET `cart`.`ordered` = 1, `cart`.`updated_at` = :today WHERE `cart`.`id` = :cart_id AND `cart`.`ordered` = 0", [
   ':cart_id' => $cart_items[0]->cart_id,
   ':today' => date("Y-m-d H:i:s")
]);

// We gaan er nu in de database een order van maken
// Stap 1 - Order aanmaken en koppelen aan customer
Database::query("INSERT INTO `orders`(`orders`.`customer_id`, `orders`.`order_date`) VALUES(:user_id, :order_date)",[
   ':user_id' => user_id(),
   ':order_date' => date("Y-m-d H:i:s")
]);

$new_order_id = Database::lastInserted();
// Stap 2 - Order items toevoegen
foreach($cart_items as $cart_item) {
   Database::query("INSERT INTO `order_items`(
         `order_items`.`order_id`,
         `order_items`.`product_id`,
         `order_items`.`amount`)
      VALUES(:order_id, :product_id, :amount)",[
         ':order_id' => $new_order_id,
         ':product_id' => $cart_item->product_id,
         ':amount' => $cart_item->amount
      ]);
}

// Hierna zal de winkelwagen die we zien op de website leeg zijn
?>

<div class="uk-grid">
   <!-- BEGIN: BEDANKT -->
   <section class="uk-width-3-3 uk-flex uk-flex-column uk-cart-gap uk-margin-large-bottom">
      <div class="uk-card-default uk-card-small uk-flex uk-flex-column uk-padding-small">
         <div class="uk-card-header">
            <h1>Bedankt voor uw bestelling</h1>
         </div>
         <div class="uk-card-body uk-flex uk-flex-column uk-flex-between">
            <div class="uk-flex uk-flex-between uk-flex-center">
               <div>
                  <h4 class="uk-margin-remove">Fijn dat u voor ons gekozen heeft.</h4>
                  <h4 class="uk-margin-remove">U ontvangt van ons binnenkort een e-mail met alle informatie over uw bestelling.</h4>
               </div>
               <div class="uk-card-default uk-padding-small uk-flex-column uk-flex-middle uk-flex-center">
                  <h3 class="uk-text-center">Bestelnummer</h3>
                  <h2 class="uk-text-center">0128671</h2>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- EINDE: BEDANKT -->

   <!-- BEGIN: EINDAFREKENING -->
   <section class="uk-width-3-3">
      <div class="uk-card-default uk-card-small uk-flex uk-flex uk-flex-column uk-flex-between uk-padding-small">
         <div class="uk-card-header">
            <h2>Uw bestelling betreft</h2>
         </div>
         <div class="uk-card-body uk-flex uk-flex-column uk-flex-between">
            <table class="uk-table uk-table-divider uk-width-2-2 order-confirm-table">
               <thead>
                  <tr>
                     <th class="uk-width-2-3">Product</th>
                     <th class="uk-text-center">Prijs</th>
                     <th class="uk-text-center">Aantal</th>
                     <th class="uk-text-right">Subtotaal</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($cart_items as $cart_item): ?>
                  <tr>
                     <td class="uk-flex uk-flex-middle uk-gap">
                        <img class="uk-order-confirm-img" src="<?= $cart_item->image ?>" alt="" />
                        <p class="uk-margin-remove"><?= $cart_item->name ?></p>
                     </td>
                     <td class="uk-text-center">&euro; <?= sprintf("%.2f", $cart_item->price) ?></td>
                     <td class="uk-text-center"><?= $cart_item->amount ?></td>
                     <td class="uk-text-right">&euro; <?= sprintf("%.2f", (floatval($cart_item->price) * floatval($cart_item->amount))) ?></td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
               <tfoot>
                  <tr>
                     <td colspan="3" class="uk-text-right uk-text-uppercase">Totaal te betalen</td>
                     <td class="uk-text-right">&euro; <?= $order_total ?></td>
                  </tr>
                  <tr>
                     <td colspan="3" class="uk-text-right uk-text-uppercase">Reeds betaald</td>
                     <td class="uk-text-right">&euro; <?= $order_total ?></td>
                  </tr>
                  <tr>
                     <td colspan="3" class="uk-text-right uk-text-uppercase uk-text-bolder">Nog te betalen</td>
                     <td class="uk-text-right uk-text-bolder">&euro; 0.00</td>
                  </tr>
               </tfoot>
            </table>
         </div>
      </div>
   </section>
   <!-- EINDE: EINDAFREKENING -->
</div>

<?php
@include_once(__DIR__ . '/template/foot.inc.php');
