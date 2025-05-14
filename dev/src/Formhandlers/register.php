<?php

@include_once(__DIR__.'/../Helpers/Auth.php');
@include_once(__DIR__.'/../Helpers/Message.php');
@include_once(__DIR__.'/../Database/Database.php');

date_default_timezone_set('Europe/Amsterdam');

$is_error = false;

// CHECK 1.1 - CHECK Request type
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
   // Geen POST-request dus stoppen we
   // We keren terug naar de login pagina
   setError('registration-error', 'Vul a.u.b. dit formulier in om als klant te registreren...');
   header('Location: ../../register.php');
   exit();
}

$old_values = [];

// CHECK 2 - Check of alle verplichte velden wel ingevuld zijn
if(!isset($_POST['firstname']) || empty($_POST['firstname'])) {
   setError('firstname-mandatory', 'Vul a.u.b. een voornaam in...');
   $is_error = true;
} else
   setOldValue('firstname', $_POST['firstname']);

if (!isset($_POST['lastname']) || empty($_POST['lastname'])) {
   setError('lastname-mandatory', 'Vul a.u.b. een achternaam in...');
   $is_error = true;
} else
   setOldValue('lastname', $_POST['lastname']);


if (!isset($_POST['street']) || empty($_POST['street'])) {
   setError('street-mandatory', 'Vul a.u.b. een straatnaam in...');
   $is_error = true;
} else
   setOldValue('street', $_POST['street']);


if (!isset($_POST['housenumber']) || empty($_POST['housenumber'])) {
   setError('housenumber-mandatory', 'Vul a.u.b. een huisnummer in...');
   $is_error = true;
} else
   setOldValue('housenumber', $_POST['housenumber']);


if (!isset($_POST['zipcode']) || empty($_POST['zipcode'])) {
   setError('zipcode-mandatory', 'Vul a.u.b. een postcode in...');
   $is_error = true;
} else
   setOldValue('zipcode', $_POST['zipcode']);


if (!isset($_POST['city']) || empty($_POST['city'])) {
   setError('city-mandatory', 'Vul a.u.b. een plaatsnaam in...');
   $is_error = true;
} else
   setOldValue('city', $_POST['city']);


if (!isset($_POST['email']) || empty($_POST['email'])) {
   setError('email-mandatory', 'Vul a.u.b. een email adres in...');
   $is_error = true;
} else
   setOldValue('email', $_POST['email']);


if (!isset($_POST['password']) || empty($_POST['password'])) {
   setError('password-mandatory', 'Vul a.u.b. een wachtwoord in...');
   $is_error = true;
}

if (!isset($_POST['password_confirm']) || empty($_POST['password_confirm'])) {
   setError('password-confirm', 'Vul a.u.b. ter controle uw wachtwoord nog eens in...');
   $is_error = true;
}

setOldValue('prefixes', (isset($_POST['prefixes']) ? $_POST['prefixes'] : ''));
setOldValue('addition', (isset($_POST['addition']) ? $_POST['addition'] : ''));

if($is_error) {
   setError('registration-error', 'Vul a.u.b. alle verplichte velden in...');
   header('Location: ../../register.php');
   exit();
}

if($_POST['password'] != $_POST['password_confirm']) {
   setError('registration-error', 'De wachtwoorden komen niet overeen. Probeer het nog eens...');
   header('Location: ../../register.php');
   exit();
}

clearOldValues();

$firstname = htmlentities($_POST['firstname']);
$lastname = htmlentities($_POST['lastname']);
$prefixes = htmlentities($_POST['prefixes']);
$street = htmlentities($_POST['street']);
$housenumber = htmlentities($_POST['housenumber']);
$addition = htmlentities($_POST['addition']);
$zipcode = htmlentities($_POST['zipcode']);
$city = htmlentities($_POST['city']);
$email = htmlentities($_POST['email']);
$password = htmlentities($_POST['password']);

Database::insert('customers',[
   'firstname' => $firstname,
   'prefixes' => $prefixes,
   'lastname' => $lastname,
   'street' => $street,
   'house_number' => $housenumber,
   'addition' => $addition,
   'zipcode' => $zipcode,
   'city' => $city,
   'email' => $email,
   'password' => password_hash($password, PASSWORD_DEFAULT)
]);

header('Location: ../../login.php');
exit();