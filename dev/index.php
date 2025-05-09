<?php

@include_once(__DIR__.'/src/Helpers/Auth.php');
@include_once(__DIR__.'/src/Helpers/Message.php');
@include_once(__DIR__.'/src/Database/Database.php');

setLastVisitedPage();

@include_once(__DIR__ . '/template/head.inc.php');

// Get all the categories first
Database::query("SELECT * FROM `categories`");
$categories = Database::getAll();

$selectedCategories = isset($_GET['categories']) ? $_GET['categories'] : [];

if (!empty($selectedCategories)) {
   $placeholders = implode(',', array_fill(0, count($selectedCategories), '?'));
   Database::query("SELECT * FROM `products` WHERE `category` IN ($placeholders)", $selectedCategories);
} else {
   Database::query("SELECT * FROM `products`");
}

$products = Database::getAll();


?>

      <!-- -- Css Styles -- -->
         <style>
         .product-image {
          width: 100%;
          height: 200px;
          object-fit: contain;
          }
          </style>
      <!-- -- Css Styles -- -->

      <?php if (hasMessage('success')): ?>
         <div class="uk-alert-success" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p><?= getMessage('success') ?></p>
         </div>
      <?php endif; ?>

      <?php if (hasError('failed')) : ?>
         <div class="uk-alert-danger" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p><?= getError('failed') ?></p>
         </div>
      <?php endif; ?>

      <div class="uk-grid">
         <section class="uk-width-1-5">
         <form method="GET" id="categoryForm">


   <h3>Categoriën</h3>
   <hr class="uk-divider" />
   <div>
      <input class="uk-checkbox" id="hoodies" type="checkbox" name="categories[]" value="hoodies"
         onchange="document.getElementById('categoryForm').submit()" 
         <?= in_array('hoodies', $selectedCategories ?? []) ? 'checked' : '' ?> />
      <label for="hoodies">Hoodies</label>
   </div>

   <div>
      <input class="uk-checkbox" id="pants" type="checkbox" name="categories[]" value="pants"
         onchange="document.getElementById('categoryForm').submit()" 
         <?= in_array('pants', $selectedCategories ?? []) ? 'checked' : '' ?> />
      <label for="pants">Pants</label>
   </div>
   <div>
      <input class="uk-checkbox" id="accesoires" type="checkbox" name="categories[]" value="accessoires"
         onchange="document.getElementById('categoryForm').submit()" 
         <?= in_array('accessoires', $selectedCategories ?? []) ? 'checked' : '' ?> />
      <label for="accessoires">Accessoires</label>
   </div>

   <div>
      <input class="uk-checkbox" id="shoes" type="checkbox" name="categories[]" value="shoes"
         onchange="document.getElementById('categoryForm').submit()" 
         <?= in_array('shoes', $selectedCategories ?? []) ? 'checked' : '' ?> />
      <label for="shoes">Shoes</label>
   </div>
</form>

         </section>
         <section class="uk-width-4-5">
            <h4 class="uk-text-muted uk-text-small">Gekozen categorieën: <?php  if (!empty($selectedCategories)) {
               echo implode(', ', array_map('ucfirst', $selectedCategories)); }
               else {
                  echo 'Alle';
               }
               ?>
            <div class="uk-flex uk-flex-home uk-flex-wrap">
               <?php foreach ($products as $product) : ?>
                  <!-- PRODUCT KAART 1 -->
                  <a class="product-card uk-card uk-card-home uk-card-default uk-card-small uk-card-hover" href="product.php?product_id=<?= $product->productID ?>">
                  <div class="uk-card-media-top uk-align-center">
                  <img src="data:image/jpeg;base64,<?= base64_encode($product->image) ?>" alt="Product image" class="product-image">
                  </div>
                  <div class="uk-card-body uk-card-body-home">
                  <p class="product-card-p"><?= substr($product->description, 0, 89) . '...' ?></p>
                  <p class="product-card-p uk-text-large uk-text-bold uk-text-danger uk-text-right">&euro; <?= $product->price ?></p>
                  </div>
                  </a>
                
               

                  <!-- EINDE PRODUCT KAART 1 -->
               <?php endforeach; ?>
            </div>
         </section>
      </div>

<?php
include_once(__DIR__ . '/template/foot.inc.php');
