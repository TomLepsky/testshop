<?php

class SiteController {
	
	public function actionIndex() {
		
		$categories = array();
		$categories = Category::getCategoriesList();
		
		
		$latestProducts = array();
		$latestProducts = Product::getLatestProducts(5);
		
		$recommendedProducts = array();
		$recommendedProducts = Product::getRecommendedProducts();
		
		require_once(ROOT . '/views/site/index.php');
		
		return true;
		
	}
	
	
	public function actionContact() {
		
		$userEmail = '';
		$userText = '';
		$result = false;
		
		if (isset($_POST['submit'])) {
			$userEmail = $_POST['userEmail'];
			$userText = $_POST['userText'];
			
			$errors = false;
			
			if (!User::checkEmail($userEmail))
				$errors[] = 'Wrong email';
			
			if ($errors == false) {
				$mailTo = 'testshop@mail.ru';
				$message = $userText . ' from ' . $userEmail;
				$theme = 'theme';
				$result = mail($mailTo, $theme, $message);
				
			}
			
		}
		
		require_once(ROOT . '/views/site/contact.php');
		
		return true;
		
	}
	
}

?>