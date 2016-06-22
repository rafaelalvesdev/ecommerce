<?php 
setlocale(LC_MONETARY, 'it_IT');

class Connection{ 
 
	private static $host		= "localhost";
	private static $db_name	= "ecommerce";
	private static $username	= "root";
	private static $password	= "";
 
	public static function getConn(){

		$conn = null;	 
		try{
			$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}		 
		return $conn;
	}
}