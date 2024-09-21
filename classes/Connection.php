<?php
class Connection {
    
    private static $connect = NULL;

    public static function getInstance() {
        if (self::$connect === NULL) {
            // Connect to the database
            $host = "localhost";
            $database = "eventcat";
            $username = "root";
            $password = "";

            $dsn = "mysql:host=" . $host . ";dbname=" . $database;
            
            try {
                self::$connect = new PDO($dsn, $username, $password);
                self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        
        return self::$connect;
    }

    public static function getMySQLDate($date) {
        $date_arr  = explode('-', $date);
        return $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr[0];
    }
}
