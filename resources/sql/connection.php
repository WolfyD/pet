<?php
    namespace PET\sql;

    use PDO;
    require_once(__DIR__ . "/../../resources/settings/config.php");

    class SQLConnection
    {
        public function createConnection()
        {
            if(
                !defined("DB_ADDRESS") ||
                !defined("DB_PORT") ||
                !defined("DB_USER") ||
                !defined("DB_NAME") ||
                !defined("DB_PASSWORD")
            )
            { 
                return null; 
            }

            $address = DB_ADDRESS;
            $port = DB_PORT;
            $user = DB_USER;
            $name = DB_NAME;
            $password = DB_PASSWORD;

            $connection_string = "mysql:host=$address;port=$port;dbname=$name;charset=UTF8";
            $pdo = new PDO($connection_string, $user, $password);
            
            return $pdo;
        }
    }