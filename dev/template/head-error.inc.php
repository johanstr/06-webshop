<?php

@include_once(__DIR__ . '/../src/Helpers/Auth.php');
@include_once(__DIR__ . '/../src/Helpers/cart_stats.php');

?>
<!DOCTYPE html>
<html lang="nl">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Webshop De Witte Kip</title>

   <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
   <link rel="manifest" href="img/site.webmanifest">

   <link rel="stylesheet" href="css/uikit.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>
   <nav class="uk-navbar-container">
      <div class="uk-container">
         <div uk-navbar>

            <div class="uk-navbar-left">
               <ul class="uk-navbar-nav">
                  <li>
                     <a href="/">
                        <img class="logo" src="img/logo4.png" alt="Webshop Het Witte Kippetje" title="Webshop Het Witte Kippetje" />
                        Het Witte Kippetje
                     </a>
                  </li>
               </ul>
            </div>

            <div class="uk-navbar-right">

               <ul class="uk-navbar-nav">
                  <li class="uk-active"><a href="/"><span uk-icon="icon: home"></span>Home</a></li>
               </ul>

            </div>
         </div>
      </div>
   </nav>

   <main class="uk-container uk-padding">