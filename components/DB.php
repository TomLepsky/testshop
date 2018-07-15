<?php

class DB {
	
	public static function getConnection() {
		$paramsPath = ROOT . '/config/db_params.php';
		$params = include($paramsPath);
		
		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
		try {
			$db = new PDO($dsn, $params['user'], $params['password']);
			
		} catch (PDOException $e) {
			echo "Connecting to db error " . $e->getMessage();
			exit();
		}
		return $db;
		
	}
	
}

?>