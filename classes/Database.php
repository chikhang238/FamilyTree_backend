<?php
class Database {
    public static $servername = 'localhost';
	public static $dbname = 'family_tree';
	public static $username = 'root';
	public static $password = 'abcdef1234';

    public static function connect(){
        $conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
    return $conn;
}
}

?>