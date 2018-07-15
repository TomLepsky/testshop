<?php

class UserController {
	
	public function actionRegister() {
		
		$name = '';
		$email = '';		
		$password = '';
		$result = false;
		
		if (isset($_POST['submit']) AND $_POST['submit'] == 'Регистрация') {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			
			$errors = false;

			if (!User::checkName($name))
				$errors[] = 'Wrong name';
			
			if (!User::checkEmail($email))
				$errors[] = 'Wrong email';
			
			if (!User::checkPassword($password))
				$errors[] = 'Wrong password';
			
			if (User::isEmailExists($email))
				$errors[] = 'Email already registred';
			
			if ($errors == false) {
				$result = User::register($name, $email, $password);
			}
			
		}
		
		require_once(ROOT . '/views/user/register.php');
		
		return true;
		
	}
	
	
	public function actionLogin() {
		
		$email = '';
		$password = '';
		
		if (isset($_POST['submit']) AND User::isGuest()) {
			
			$email = $_POST['email'];
			$password = $_POST['password'];
			
			$errors = false;
			
			if (!User::checkEmail($email))
				$errors[] = 'Wrong email';
			
			if (!User::checkPassword($password))
				$errors[] = 'Wrong password';
			
			$userId = User::checkUserData($email, $password);
			
			if ($userId == false) 
				$errors[] = 'Wrong data';
			else {
				User::auth($userId);
				
				header("Location: /cabinet/");
			}
				
		}
		
		if (User::isGuest())
			require_once(ROOT . '/views/user/login.php');
		else 
			header("Location: /");
		
		return true;
		
	}
	
	
	public function actionLogout() {
		
		unset($_SESSION['user']);
		header("Location: /");
		
	}
		
}

?>