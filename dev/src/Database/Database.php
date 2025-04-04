<?php


class Database
{
   private static $dbHost = "db";
   private static $dbName = "webshop";
   private static $dbUser = "root";
   private static $dbPassword = "root";

   private static $dbConnection = null;
   private static $dbStatement = null;

   private static function connect(): bool
   {
      if (!is_null(self::$dbConnection)) {
         return true;
      }

      $pdo = null;
      try {
         $dsn = "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName;
         $pdo = new PDO($dsn, self::$dbUser, self::$dbPassword);

         $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      } catch (PDOException $e) {
         return false;
      }

      self::$dbConnection = $pdo;
      return true;
   }

   public static function setup(string $dbname, string $user, string $password): void
   {
      if(! is_null($dbname) && ! empty($dbname))
         self::$dbName = $dbname;

      if(! is_null($user) && ! empty($user))
         self::$dbUser = $user;

      if(! is_null($password) && ! empty($password))
         self::$dbPassword = $password;
   }

   public static function query(string $query, array $params = []): bool
   {
      if (!self::connect())
         return false;

      try {
         self::$dbStatement = self::$dbConnection->prepare($query);
         self::$dbStatement->execute($params);
      } catch (PDOException $e) {
         return false;
      }

      return true;
   }

   public static function get($return_type = PDO::FETCH_OBJ): bool|Object|array
   {
      if (!self::connect())
         return false;

      return self::$dbStatement->fetch($return_type);
   }

   public static function getAll($return_type = PDO::FETCH_OBJ): bool|array
   {
      if (!self::connect())
         return false;

      return self::$dbStatement->fetchAll($return_type);
   }

   public static function lastInserted(): int|bool
   {
      if (!is_null(self::$dbConnection))
         return self::$dbConnection->lastInsertId();

      return false;
   }

   private static function destructureInsertData(array $data): array
   {
      $column_names = '';
      $values = '';
      $first = true;
      foreach ($data as $column => $value) {
         $placeholders[':' . $column] = $value;
         if ($first) {
            $column_names .= "`$column`";
            $values .= (is_int($value) ? "$value" : "'$value'");
            $first = false;
         } else {
            $column_names .= ", `$column`";
            $values .= (is_int($value) ? ", $value" : ", '$value'");
         }
      }

      return [
         'column_names' => $column_names,
         'values' => $values
      ];
   }

   public static function insert(string $table, array $data): bool|Object
   {
      [
         'column_names' => $column_names,
         'values' => $values
      ] = self::destructureInsertData($data);
      $created_at = date("Y-m-d H:i:s"); //Carbon::now()->toDateTimeString();

      $sql = "INSERT INTO `$table`($column_names, `created_at`, `updated_at`) VALUES($values, '$created_at', '$created_at')";

      self::query($sql);

      $lastId = self::lastInserted();
      if (self::query("SELECT `$table`.* FROM `$table` WHERE `$table`.`id` = $lastId")) {
         return self::get();
      }

      return false;
   }

   private static function destructureUpdateData(array $data): array
   {
      $result = [
         'sql' => '',
         'placeholders' => []
      ];
      $first = true;

      foreach ($data as $column => $value) {
         if ($first) {
            $first = false;
            $result['sql'] .= "`$column` = :$column";
         } else {
            $result['sql'] .= ", `$column` = :$column";
         }

         $result['placeholders'][":$column"] = $value;
      }

      return $result;
   }

   public static function update(string $table, int $id, array $data = []): bool|Object|array
   {
      ['sql' => $set_fields, 'placeholders' => $placeholders] = self::destructureUpdateData($data);

      $updated_at = date("Y-m-d H:i:s"); //Carbon::now()->toDateTimeString();

      $sql = "UPDATE `$table` SET $set_fields, `updated_at` = '$updated_at' WHERE `$table`.`id` = $id";
      self::query($sql, $placeholders);

      self::query("SELECT * FROM `$table` WHERE `$table`.`id` = $id");

      return self::get();
   }
}