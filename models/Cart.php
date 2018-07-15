<?php

class Cart {
	
	public static function addProduct($productId) {
	
		$productId = intval($productId);
			
		if ($productId > 0) {
			
			$productsInCart = array();
	
			if (isset($_SESSION['products']))
				$productsInCart = $_SESSION['products'];
			
			if (array_key_exists($productId, $productsInCart))
				$productsInCart[$productId]++;
			else
				$productsInCart[$productId] = 1;
			
			$_SESSION['products'] = $productsInCart;
			
		}
		
	}
	
	
	public static function countItems() {
		
		$count = 0;
		
		if (isset($_SESSION['products'])) 
			foreach ($_SESSION['products'] as $product => $quantity) 
				$count += $quantity;
		
		return $count;
		
	}
	
	
	public static function getProducts() {
		
		if (isset($_SESSION['products']))
			return $_SESSION['products'];
		
		return false;
		
	}
	
	
	public static function getTotalPrice($products) {
		
		$productsInCart = self::getProducts();
		$total = 0;
		
		if ($productsInCart) {
			foreach ($products as $product) {
				$total += $product['price'] * $productsInCart[$product['id']];
			}
		}
		
		return $total;
		
	}
	
	
	public static function clear() {
		if (isset($_SESSION['products']))
			unset($_SESSION['products']);
		
	}
	
	
	public static function deleteProductFromCart($productId) {
		
		$productsInCart = self::getProducts();
		$productId = intval($productId);
		
		if ($productsInCart != false) {
			
			$productsIds = array_keys($productsInCart);
			if (in_array($productId, $productsIds)) {
				$_SESSION['products'][$productId]--;
				
				if ($_SESSION['products'][$productId] <= 0)
					unset($_SESSION['products'][$productId]);
				
				return true;
			}
			
		}
		return false;
		
	}
	
	
}

?>