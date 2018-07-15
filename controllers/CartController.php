<?php

class CartController {

	public function actionIndex() {
		
		$categories = array();
		$categories = Category::getCategoriesList();
		
		$productsInCart = false;
		
		$productsInCart = Cart::getProducts();
		
		if ($productsInCart) {
			$productsIds = array_keys($productsInCart);
			$products = Product::getProductsByIds($productsIds);
			
			$totalPrice = Cart::getTotalPrice($products);
		}
		
		require_once(ROOT . '/views/cart/index.php');
		
		return true;
		
	}
	
	
	public function actionAdd($productId) {
		
		Cart::addProduct($productId);
		
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		
		return true;
		
	} 
	
	
	public function actionAddAjax($productId) {
		
		Cart::addProduct($productId);
		
		echo Cart::countItems();
		return true;
		
	}
	
	
	public function actionCheckout() {
		
		$categories = array();
		$categories = Category::getCategoriesList();
		
		$result = false;
		
		$userName = '';
		$userPhone = '';
		$userComment = '';
			
		if (isset($_POST['submit'])) {
			
			$userName = $_POST['userName'];
			$userPhone = $_POST['userPhone'];
			$userComment = $_POST['userComment'];
			
			$errors = false;
			
			if (!User::checkName($userName))
				$errors[] = 'Wrong name';
			
			if (!User::checkPhone($userPhone))
				$errors[] = 'Wrong phone number';
			
			if ($errors == false) {
				
				$productsInCart = Cart::getProducts();
				if (User::isGuest())
					$userId = false;
				else
					$userId = User::checkLogged();
				
				$result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);
				
				if ($result) {
					
					$emailTo = 'index@testshop.ru';
					$theme = 'New order';
					$message = 'testshop.ru/admin/orders';
					mail($emailTo, $theme, $message);
					
					Cart::clear();
					
				}
				
			} else {
				
				//Some errors occured
				
				$productsInCart = Cart::getProducts();
				$productsIds = array_keys($productsInCart);
				$products = Product::getProductsByIds($productsIds);
				$totalPrice = Cart::getTotalPrice($products);
				$totalQuantity = Cart::countItems();
				
			}
				
			//Form not send				
		} else {
			
			$productsInCart = Cart::getProducts();
			
			if ($productsInCart == false) 
				header('Location: /');
			
			//Some products in cart
			else {
				
				$productsIds = array_keys($productsInCart);
				$products = Product::getProductsByIds($productsIds);
				$totalPrice = Cart::getTotalPrice($products);
				$totalQuantity = Cart::countItems();
				
				if (!User::isGuest()) {
					
					$userId = User::checkLogged();
					$user = User::getUserById($userId);
					$userName = $user['name'];
					
				}
				
			}
			
		}
		
		require_once(ROOT . '/views/cart/checkout.php');
		
		return true;
		
	}
	
	
	public function actionDelete($productId) {
		
		if (Cart::deleteProductFromCart($productId))
			header('Location: /cart/');
		else
			header('Location: /');
		
		return true;
		
	}
	
	
}

?>