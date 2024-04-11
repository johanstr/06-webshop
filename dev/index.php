<?php

@include_once(__DIR__.'/src/Helpers/Auth.php');
@include_once(__DIR__.'/src/Helpers/Message.php');
@include_once(__DIR__.'/src/Database/Database.php');

setLastVisitedPage();

@include_once(__DIR__ . '/template/head.inc.php');

// Get all the categories first
Database::query("SELECT * FROM `categories`");
$categories = Database::getAll();

// Now get all the products
Database::query("SELECT * FROM `products`");
$products = Database::getAll();

?>
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
            <h4>Categoriën</h4>
            <hr class="uk-divider" />
            <div>
               <input class="uk-checkbox" id="chickens" type="checkbox" name="chickens" />
               <label for="chickens">Wedstrijd kippen</label>
            </div>
            <div>
               <input class="uk-checkbox" id="paint" type="checkbox" name="paint" />
               <label for="paint">Verf</label>
            </div>
            <div>
               <input class="uk-checkbox" id="machines" type="checkbox" name="machines" />
               <label for="machines">Broedmachines</label>
            </div>
            <div>
               <input class="uk-checkbox" id="hokken" type="checkbox" name="hokken" />
               <label for="hokken">Hokken</label>
            </div>
         </section>
         <section class="uk-width-4-5">
            <h4 class="uk-text-muted uk-text-small">Gekozen categorieën: <span class="uk-text-small uk-text-primary">Alle</span></h4>
            <div class="uk-flex uk-flex-home uk-flex-wrap">
               <?php foreach ($products as $product) : ?>
                  <!-- PRODUCT KAART 1 -->
                  <a class="product-card uk-card uk-card-home uk-card-default uk-card-small uk-card-hover" href="product.php?product_id=<?= $product->id ?>">
                     <div class="uk-card-media-top uk-align-center">
                        <img src="<?= $product->image ?>" alt="Witte kip" class="product-image uk-align-center">
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
