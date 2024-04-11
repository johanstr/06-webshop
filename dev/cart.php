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


foreach ($cart_items as $cart_item) {
   $cart_total_amount += intval($cart_item->amount);
   $cart_total_cost += floatval($cart_item->product_total);
}
$order_total = $cart_total_cost + $shipping_cost;

?>
<div class="uk-grid">
   <section class="uk-width-2-3 uk-flex uk-flex-column uk-cart-gap">
      <?php if ($cart_total_amount > 0) : ?>
         <?php foreach ($cart_items as $cart_item) : ?>
            <!-- BEGIN: SHOPPINGCART PRODUCT 1 -->
            <div class="uk-card-default uk-card-small uk-flex uk-flex-between">
               <div class="uk-card-media-left uk-widht-1-5">
                  <img src="<?= $cart_item->image ?>" alt="Witte kip" class="product-image uk-align-center">
               </div>
               <div class="uk-card-body uk-width-4-5 uk-flex uk-flex-between">
                  <div class="uk-width-3-4 uk-flex uk-flex-column">
                     <h2><?= $cart_item->name ?></h2>
                     <p class="uk-margin-remove-top">
                        <?= substr($cart_item->description, 0, 120) . '...' ?>
                     </p>
                     <div class="uk-flex uk-flex-between">
                        <p class="uk-text-primary uk-text-bold">Prijs per stuk: &euro; <?= sprintf("%.2f", $cart_item->price) ?></p>
                        <p class="uk-text-primary uk-text-bold uk-margin-remove-top">Totaal: &euro; <?= sprintf("%.2f", $cart_item->product_total) ?></p>
                     </div>
                  </div>
                  <div class="uk-width-1-4 uk-flex uk-flex-between uk-flex-middle uk-flex-center">
                     <div class="uk-width-3-4 uk-flex uk-flex-column uk-flex-middle">
                        <form id="new-amount-form-<?= $cart_item->product_id ?>" method="POST" action="src/Formhandlers/change_amount.php" style="display: none">
                           <input type="hidden" value="<?= $cart_item->cart_id ?>" name="cart_id" />
                           <input type="hidden" value="<?= $cart_item->product_id ?>" name="product_id" />
                           <input type="hidden" id="new-amount-<?= $cart_item->product_id ?>" name="amount" />
                        </form>
                        <input id="amount-<?= $cart_item->product_id ?>" class="uk-form-controls uk-form-width-xsmall uk-text-medium" name="amount" value="<?= $cart_item->amount ?>" type="number" onchange="changeAmount(<?= $cart_item->product_id ?>)" />
                     </div>
                     <div class="uk-width-1-4">
                        <a href="#" class="uk-link-cart-trash uk-flex uk-flex-column uk-flex-middle uk-text-danger uk-flex-1">
                           <form id="delete-product-<?= $cart_item->product_id ?>" method="POST" action="src/Formhandlers/delete_product.php" style="display: none;">
                              <input type="hidden" value="<?= $cart_item->cart_id ?>" name="cart_id" />
                              <input type="hidden" name="product_id" value="<?= $cart_item->product_id ?>" />
                           </form>
                           <span uk-icon="icon: trash" onclick="deleteProduct(<?= $cart_item->product_id ?>)"></span>
                           <span class="uk-text-xsmall" onclick="deleteProduct(<?= $cart_item->product_id ?>)">Verwijder</span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <!-- EINDE: SHOPPINGCART PRODUCT 1 -->
         <?php endforeach; ?>
      <?php else : ?>
         <div class="uk-card-default uk-card-small uk-flex uk-flex-between">
            <div class="uk-card-body uk-width-4-5 uk-flex uk-flex-between">
               <h3>Nog geen artikelen in de winkelwagen.</h3>
            </div>
         </div>
      <?php endif; ?>
   </section>
   <section class="uk-width-1-3">
      <div class="uk-card uk-card-default uk-card-small">
         <div class="uk-card-header uk-align-center">
            <h2>Overzicht</h2>
         </div>
         <div class="uk-card-body">
            <div class="uk-flex uk-flex-between uk-flex-middle">
               <p class="uk-width-1-2">Artikelen (<?= $cart_total_amount ?>)</p>
               <p class="uk-width-1-2 uk-margin-remove-top uk-text-right">
                  &euro; <?= sprintf("%.2f", $cart_total_cost) ?>
               </p>
            </div>
            <div class="uk-flex uk-flex-between uk-flex-middle">
               <p class="uk-width-1-2">Verzendkosten</p>
               <p class="uk-width-1-2 uk-margin-remove-top uk-text-right">
                  &euro; <?= sprintf("%.2f", $shipping_cost) ?>
               </p>
            </div>
         </div>
         <div class="uk-card-footer">
            <div class="uk-flex uk-flex-between uk-flex-middle">
               <p class="uk-width-1-2 uk-text-bold">Te betalen</p>
               <p class="uk-width-1-2 uk-margin-remove-top uk-text-right uk-text-bold">
                  &euro; <?= sprintf("%.2f", $order_total) ?>
               </p>
            </div>
            <div class="uk-flex uk-flex-1 uk-flex-middle uk-flex-center uk-margin-medium-top">
               <a href="order.php" class="uk-button uk-button-primary">
                  Verder naar bestellen
               </a>
            </div>
         </div>
      </div>
   </section>
</div>


<?php
@include_once(__DIR__ . '/template/foot.inc.php');
