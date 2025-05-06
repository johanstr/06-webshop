
<?php
@include_once(__DIR__.'/src/Database/Database.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (Database::query("SELECT COUNT(*) as count FROM products")) {
    $result = Database::get();
    echo "Database connected, the amount of products are:
    " . $result->count;
}
 else {
    echo "Database failed to connect.";
}
