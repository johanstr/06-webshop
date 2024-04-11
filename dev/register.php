<?php

@include_once(__DIR__ . '/src/Helpers/Auth.php');
@include_once(__DIR__ . '/src/Helpers/Message.php');

include_once(__DIR__ . '/template/head.inc.php');
?>

<form method="POST" action="src/Formhandlers/register.php" class="uk-width-1-1 uk-flex uk-flex-center">
   <div class="uk-card uk-card-default uk-width-4-5 uk-padding-small">
      <div class="uk-card-header uk-flex uk-gap">
         <img src="img/logo4.png" class="uk-card-media uk-card-register-logo" alt="Webshop Het Witte Kippetje" title="Webshop Het Witte Kippetje" />
         <h2 class="uk-text-uppercase uk-margin-remove-top">Registreren</h2>
      </div>
      <?php if (hasError('registration-error')) : ?>
         <div class="uk-alert-danger" uk-alert>
            <a href class="uk-alert-close" uk-close></a>
            <p><?= getError('registration-error') ?></p>
         </div>
      <?php endif; ?>
      <div class="uk-card-body uk-flex uk-flex-between uk-card-body-gap">
         <div class="uk-width-1-1 uk-flex uk-flex-column">
            <div class="">
               <label for="firstname" class="uk-form-label">Voornaam</label>
               <input type="text" name="firstname" class="uk-input" id="firstname" placeholder="Voornaam..." value="<?= old('firstname') ?>" />
               <?php if (hasError('firstname-mandatory')) : ?>
                  <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                     <?= getError('firstname-mandatory') ?>
                  </p>
               <?php endif; ?>
            </div>
            <div class="uk-flex uk-gap uk-margin-top">
               <div class="uk-width-1-5">
                  <label for="prefixes" class="uk-form-label">Tussenvoegsels<span class="uk-text-xsmall uk-text-italic uk-text-primary"> (Optioneel)</span></label>
                  <input type="text" name="prefixes" class="uk-input" id="prefixes" placeholder="Tussenvoegsels..." value="<?= old('prefixes') ?>" />
               </div>
               <div class="uk-width-4-5">
                  <label for="lastname" class="uk-form-label">Achternaam</label>
                  <input type="text" name="lastname" class="uk-input" id="lastname" placeholder="Achternaam..." value="<?= old('lastname') ?>" />
                  <?php if (hasError('lastname-mandatory')) : ?>
                     <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                        <?= getError('lastname-mandatory') ?>
                     </p>
                  <?php endif; ?>
               </div>
            </div>

            <div class="uk-flex uk-gap uk-margin-top">
               <div class="uk-width-3-5">
                  <label for="street" class="uk-form-label">Straatnaam</label>
                  <input type="text" name="street" class="uk-input" id="street" placeholder="Straatnaam..." value="<?= old('street') ?>" />
                  <?php if (hasError('street-mandatory')) : ?>
                     <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                        <?= getError('street-mandatory') ?>
                     </p>
                  <?php endif; ?>
               </div>
               <div class="uk-width-1-5">
                  <label for="housenumber" class="uk-form-label">Huisnummer</label>
                  <input type="text" name="housenumber" class="uk-input" id="housenumber" placeholder="Huisnummer..." value="<?= old('housenumber') ?>" />
                  <?php if (hasError('housenumber-mandatory')) : ?>
                     <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                        <?= getError('housenumber-mandatory') ?>
                     </p>
                  <?php endif; ?>
               </div>
               <div class="uk-width-1-5">
                  <label for="addition" class="uk-form-label">Toevoeging<span class="uk-text-xsmall uk-text-italic uk-text-primary"> (Optioneel)</span></label>
                  <input type="text" name="addition" class="uk-input" id="addition" placeholder="Toevoeging..." value="<?= old('addition') ?>" />
               </div>
            </div>
            <div class="uk-flex uk-gap uk-margin-top">
               <div class="uk-width-1-5">
                  <label for="zipcode" class="uk-form-label">Postcode</label>
                  <input type="text" name="zipcode" class="uk-input" id="zipcode" placeholder="Postcode..." value="<?= old('zipcode') ?>" />
                  <?php if (hasError('zipcode-mandatory')) : ?>
                     <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                        <?= getError('zipcode-mandatory') ?>
                     </p>
                  <?php endif; ?>
               </div>
               <div class="uk-width-4-5">
                  <label for="city" class="uk-form-label">Plaats</label>
                  <input type="text" name="city" class="uk-input" id="city" placeholder="Plaats..." value="<?= old('city') ?>" />
                  <?php if (hasError('city-mandatory')) : ?>
                     <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                        <?= getError('city-mandatory') ?>
                     </p>
                  <?php endif; ?>
               </div>
            </div>
            <div class="uk-margin-top">
               <label for="email" class="uk-form-label">Email</label>
               <input type="email" name="email" class="uk-input" id="email" placeholder="E-mail adres..." value="<?= old('email') ?>" />
               <?php if (hasError('email-mandatory')) : ?>
                  <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                     <?= getError('email-mandatory') ?>
                  </p>
               <?php endif; ?>
            </div>
            <div class="uk-margin-top">
               <label for="password" class="uk-form-label">Wachtwoord</label>
               <input type="password" name="password" class="uk-input" id="password" placeholder="Wachtwoord..." />
               <?php if (hasError('password-mandatory')) : ?>
                  <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                     <?= getError('password-mandatory') ?>
                  </p>
               <?php endif; ?>
            </div>
            <div class="uk-margin-top">
               <label for="password-confirm" class="uk-form-label">Wachtwoord controle</label>
               <input type="password" name="password_confirm" class="uk-input" id="password-confirm" placeholder="Voer het wachtwoord nog eens in ter controle..." />
               <?php if (hasError('password-confirm')) : ?>
                  <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">
                     <?= getError('password-confirm') ?>
                  </p>
               <?php endif; ?>
            </div>
         </div>
      </div>
      <div class="uk-card-footer uk-flex uk-flex-between">
         <a href="login.html" class="">Inloggen</a>
         <button class="uk-button uk-button-primary" type="submit">Registreren</button>
      </div>
   </div>
</form>

<?php
include_once(__DIR__ . '/template/foot.inc.php');
