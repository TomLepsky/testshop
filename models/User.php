<?php

class User {
	
	public static function register($name, $email, $password) {
		
		$db = DB::getConnection();
		
		$sql = "INSERT INTO user (name, email, password, role) VALUES (:name, :email, :password, 'user')";
		
		$result = $db->prepare($sql);
		$result->bindValue(':name', $name, PDO::PARAM_STR);
		$result->bindValue(':email', $email, PDO::PARAM_STR);
		$result->bindValue(':password', $password, PDO::PARAM_STR);
		
		$result->execute();
		
		return $result;
		
	}
	
	
	public static function checkName($name) {
		if (strlen($name) > 1) return true;
		
		return false;
		
	}
	
	
	public static function checkPassword($password) {
		if (strlen($password) >= 6) return true;
		
		return false;
		
	}
	
	
	public static function checkEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
		
		return false;
		
	}
	
	
	public static function checkPhone($phone) {
		if (preg_match('~[\d]{11}~', $phone))
			return true;
		
		return false;
		
	}
	
	
	public static function isEmailExists($email) {
		
		$db = DB::getConnection();
		
		$sql = 'SELECT count(*) FROM user WHERE email = :email';
		
		$result = $db->prepare($sql);
		$result->bindValue(':email', $email, PDO::PARAM_STR);
		$result->execute();

		if ($result->fetchColumn()) 
			return true;
		
		return false;
		
	}
	
	
	public static function checkUserData($email, $password) {
		
		$db = DB::getConnection();
		
		$query = 'SELECT * FROM user WHERE email = :email AND password = :password';
		
		$result = $db->prepare($query);
		$result->bindValue(':email', $email);
		$result->bindValue(':password', $password);
		$result->execute();
		
		$user = $result->fetch();
		if ($user) {
			return $user['id'];
		}
		
		return false;
		
	}
	
	
	public static function auth($userId) {
		
		$_SESSION['user'] = $userId;
		
	}
	
	
	public static function checkLogged() {
		
		if (isset($_SESSION['user']))
			return $_SESSION['user'];
			
		header("Location: /user/login");
		
	}
	
	
	public static function isGuest() {
		
		if (isset($_SESSION['user']))
			return false;
		
		return true;
		
	}
	
	
	public static function getUserById($userId) {
		
		$db = DB::getConnection();
		
		$query = 'SELECT * FROM user WHERE id = :id';
		
		$result = $db->prepare($query);
		$result->bindValue(':id', $userId);
		$result->execute();
		
		return $result->fetch();
		
	}
	
	
	public static function edit($userId, $name, $password) {
		
		$db = DB::getConnection();
		
		$query = 'UPDATE user SET name = :name, password = :password WHERE id = :id';
		
		$result = $db->prepare($query);
		$result->bindValue(':name', $name, PDO::PARAM_STR);
		$result->bindValue(':password', $password, PDO::PARAM_STR);
		$result->bindValue(':id', $userId, PDO::PARAM_INT);
		
		return $result->execute();
		
	}
	
	
}

?>