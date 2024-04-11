<?php

@include_once(__DIR__.'/src/Database/Database.php');

function countItemsInCart(): int
{
   $amount = 0;

   if(isLoggedIn()) {
      Database::query(
         "SELECT 
            `cart`.`customer_id`,
            `cart_items`.`cart_id`,
            SUM(`cart_items`.`amount`) AS `total_items`
         FROM `cart`
         LEFT JOIN `cart_items` ON `cart`.`id` = `cart_items`.`cart_id`
         WHERE `cart`.`ordered` = 0 AND `cart`.`customer_id` = :id
         GROUP BY `cart`.`id`", 
         [':id' => user_id()]
      );

      $record = Database::get();

      if(!empty($record) && !is_null($record))
         $amount = intval($record->total_items);
   }

   return $amount;
}