<?php

if(session_status() !== PHP_SESSION_ACTIVE) @session_start();

function has(string $key, string $domain = ''): bool
{
   if(!is_null($domain) && !empty($domain)) {
      if(isset($_SESSION[$domain]) && array_key_exists($key, $_SESSION[$domain]) && !empty($_SESSION[$domain][$key]))
         return true;
   } else {
      if(array_key_exists($key, $_SESSION) && !empty($_SESSION[$key]))
         return true;
   }

   return false;
}

function hasError(string $key): bool
{
   if(isset($_SESSION['errors'])) {
      if(array_key_exists($key, $_SESSION['errors']))
         return true;
   }
   return false;
}

function hasMessage(string $key): bool
{
   if (isset($_SESSION['messages'])) {
      if (array_key_exists($key, $_SESSION['messages']))
         return true;
   }
   return false;
}

function getError(string $key): string|array|stdClass|null
{
   $error_msg = '';

   if(hasError($key)) {
      $error_msg = $_SESSION['errors'][$key];
      unset($_SESSION['errors'][$key]);
   }

   return $error_msg;
}

function getMessage(string $key): string|array|stdClass|null
{
   $message = '';
   if (hasMessage($key)) {
      $message = $_SESSION['messages'][$key];
      unset($_SESSION['messages'][$key]);
   }

   return $message;
}

function setError(string $key, mixed $value): void
{
   $_SESSION['errors'][$key] = $value;
}

function setMessage(string $key, mixed $value): void
{
   $_SESSION['messages'][$key] = $value;
}

function setOldValue(string $key, mixed $value): void
{
   $_SESSION['old'][$key] = $value;
}

function setOldValues(mixed $values): void
{
   $_SESSION['old'] = $values;
}

function old(string $key): mixed
{
   $old_value = '';
   if(has($key, 'old')) {
      $old_value = $_SESSION['old'][$key];
      unset($_SESSION['old'][$key]);
   }

   return $old_value;
}

function clearOldValues(): void
{
   if(isset($_SESSION['old']))
      unset($_SESSION['old']);
}
