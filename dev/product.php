<?php

@include_once(__DIR__.'/src/Helpers/Auth.php');
@include_once(__DIR__.'/src/Helpers/Message.php');
@include_once(__DIR__.'/src/Database/Database.php');

setLastVisitedPage();

@include_once(__DIR__ . '/template/head.inc.php');

if (!isset($_GET['product_id'])) {
   setError('failed', 'Geen ID van het product ontvangen.');
   header('Location: index.php');
   exit(0);
}

$product_id = $_GET['product_id'];

// Now get all the products
Database::query("SELECT * FROM `products` WHERE `products`.`productID` = :id", [':id' => $product_id]);
$product = Database::get();
?>

<div class="uk-grid">
   <section class="uk-width-1">
      <div class="uk-grid uk-card uk-card-default">
         <section class="uk-width-1-2 uk-card-media-left">
            <img src="<?= $product->image ?>" class="" alt="" title="" />
         </section>
         <section class="uk-width-1-2 uk-card-body uk-flex uk-flex-column uk-flex-between">
            <div class="">
               <h1><?= $product->productname ?></h1>
               <p class="">
                  <?= $product->description ?>
               </p>
            </div>
            <div class="uk-flex uk-flex-between uk-flex-middle">
               <div class="price-block">
                  <p class="product-view__price uk-text-bold uk-text-danger uk-text-left uk-text-bolder">
                     &euro; <?= $product->price ?>
                  </p>
               </div>
               <div>
                  <?php if (isLoggedIn()) : ?>
                     <form method="POST" action="src/Formhandlers/addtocart.php">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>" />
                        <button type="submit" class="uk-button uk-button-primary">
                           <span uk-icon="icon: cart"></span>
                           In winkelwagen
                        </button>
                     </form>
                  <?php else : ?>
                     <a href="javascript:void" class="uk-button uk-button-primary" onclick="event.preventDefault(); alert('Om te kunnen bestellen dient u geregistreerd en ingelogd te zijn.');">
                        <span uk-icon="icon: cart"></span>
                        In winkelwagen
                     </a>
                  <?php endif; ?>
               </div>
            </div>
         </section>
      </div>
   </section>
</div>

<?php
@include_once(__DIR__ . '/template/foot.inc.php');
