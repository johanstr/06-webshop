<?php

@include_once(__DIR__.'/../Helpers/Auth.php');
@include_once(__DIR__.'/../Helpers/Message.php');
@include_once(__DIR__.'/../Database/Database.php');

date_default_timezone_set('Europe/Amsterdam');

// CHECK 1 - CHECK Request type
if($_SERVER['REQUEST_METHOD'] != 'POST') {
   // Geen POST-request dus stoppen we
   // We keren terug naar de login pagina
   setError('credentials-error', 'U dient via dit formulier in te loggen. Vul a.u.b. dit formulier in...');
   header('Location: ../../login.php');
   exit();
}

// CHECK 2 - CHECK benodigde gegevens
if(!isset($_POST['email']) || !isset($_POST['password'])) {
   // Informatie ontbreekt, dus terug naar login pagina
   setError('credentials-error', 'Er ontbreken gegevens om in te loggen');

   if(!isset($_POST['email']))
      setError('email-mandatory', 'Vul a.u.b. uw email adres in');

   if(!isset($_POST['password']))
      setError('password-mandatory', 'Vul a.u.b. uw wachtwoord in');

   header('Location: ../../login.php');
   exit();
}

// Nu kunnen we pas verder, maar beveiligen de input wel eerst tegen injectie
$email = htmlentities($_POST['email']);
$password = htmlentities($_POST['password']);

Database::query("SELECT * FROM `customers` WHERE `customers`.`email` = :email", [':email' => $email]);
$customer = Database::get();

// Nu kunnen we pas het wachtwoord vergelijken vanwege de encrypted opgeslagen password
if(password_verify($password, $customer->password)) {
   // Wachtwoorden komen overeen, dus inloggen maar
   if(login($customer)) {
      setMessage('success', 'U bent succesvol ingelogd.');
      header('Location: '. getLastVisitedPage());
      exit();
   } else {
      setError('credentials-error', 'Er is iets fout gegaan tijdens het inloggen. Probeer a.u.b. nog eens...');
      header('Location: ../../login.php');
      exit();
   }
} else {
   setError('credentials-error', 'De ingevoerde credentials komen niet overeen met onze gegevens. Probeer a.u.b. opnieuw...');
   header('Location: ../../login.php');
   exit();
}
