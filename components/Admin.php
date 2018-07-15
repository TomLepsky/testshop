<?php

Abstract class Admin {
	
	public static function checkAdmin() {
		
		if (!User::isGuest()) {
			
			$userId = User::checkLogged();
			$user = User::getUserById($userId);
			
			if ($user['role'] == 'admin')
				return true;
			
		}
		
		echo "(>_<) ...";
		exit();
		
	}
	
}

?>