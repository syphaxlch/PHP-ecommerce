<?php
    class Database{
        private static  $dbhost="localhost";
        private static  $dbName="ecommerce";
        private static  $dbUser="root";
        private static  $dbUserPassword=""; 

   private static $connexion=null;
  public static function connect(){
    try{
        self::$connexion  = new PDO("mysql:host=" . self::$dbhost. ";dbname=". self::$dbName, self::$dbUser, self::$dbUserPassword);
       }
       catch(PDOException $e)
       {
           die($e->getMessage());
       }
      return self::$connexion;
    }
    public static  function Disconnect(){
    self::$connexion= null;
   }
}

Database::connect();
?>