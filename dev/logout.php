<?php

@include_once(__DIR__.'/src/Helpers/Auth.php');

$original_location = getLastVisitedPage();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
   if(isset($_POST['user_id']) && $_POST['user_id'] == user_id()) {
      logout();
   }
}

if(!headers_sent()) {
   header('Location: ' . $original_location);
   exit();
}