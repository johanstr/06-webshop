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

<!-- -- Css Style -- -->
<style>
  .product-image {
    width: 100%;
    height: 500px;
    object-fit: contain;
  }
</style>

 <button class="btn" onclick="history.back()">Go Back</button>

<style>
  .btn {
    background-color:rgb(6, 72, 255);
    color: white;
    padding: 12px 16px;
    margin: 0px -200px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .btn:hover {
    background-color:rgb(0, 56, 177);
    transform: translateY(-2px);
  }

  .btn:active {
    background-color:rgb(0, 0, 0);
    transform: translateY(0);
  }
</style>

<!-- -- Css Styles -- -->

<div class="uk-grid">
   <section class="uk-width-1">
      <div class="uk-grid uk-card uk-card-default">
         <section class="uk-width-1-2 uk-card-media-left">
            <img src="data:AnimeHoodie/jpg;base64,<?= base64_encode($product->image) ?>" alt="Product image" class="product-image uk-align-center uk-width-1-1 uk-height-auto uk-object-cover">
         </section>
         <section class="uk-width-1-2 uk-card-body uk-flex uk-flex-column uk-flex-between">
            <div>
               <h1><?= $product->productname ?></h1>
               <p>
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
                     <form method="POST" action="src/Formhandlers/favorite.php" class="favorite-form">
                     <input type="hidden" name="product_id" value="<?= $product->id ?>" />
                     <button type="submit" class="uk-button uk-button-default favorite-button">
                     <span uk-icon="icon: heart"></span>
                     Favoriet
                     </button>
                     </form>
                  <?php endif; ?>
               </div>
            </div>
         </section>
      </div>
   </section>
</div>

<?php
@include_once(__DIR__ . '/template/foot.inc.php');
