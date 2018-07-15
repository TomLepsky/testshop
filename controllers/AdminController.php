<?php

class AdminController extends Admin {
	
	public function actionIndex() {
		
		if (self::checkAdmin())
			require_once(ROOT . '/views/admin/index.php');
		
		return true;
		
	}
	
}

?>