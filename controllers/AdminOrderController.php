<?php

class AdminOrderController extends Admin{
	
	public function actionIndex() {
		
		self::checkAdmin();
		
		$ordersList = array();
		$ordersList = Order::getOrdersList();
		
		require_once(ROOT . '/views/admin_order/index.php');
		
		return true;		
		
	}
	

	public function actionUpdate($orderId) {
		
		self::checkAdmin();
		
		$order = Order::getOrderById($orderId);
		
		if (isset($_POST['submit'])) {
			
			$newOrder['user_name'] = $_POST['user_name'];
			$newOrder['user_phone'] = $_POST['user_phone'];
			$newOrder['status'] = $_POST['status'];	
			$newOrder['user_comment'] = $_POST['user_comment'];	
			$newOrder['date'] = $_POST['date'];	
			
			$errors = false;
			
			if (!isset($newOrder['user_name']) || empty($newOrder['user_name'])) 
				$errors[] = 'wrong data';
			
			if ($errors == false) {
				Order::updateOrderById($orderId, $newOrder);

				header('Location: /admin/order');
			}
			
		}
		
		require_once(ROOT . '/views/admin_order/update.php');
		
		return true;
		
	}	
	
	
	public function actionDelete($orderId) {
		
		self::checkAdmin();
		
		if (isset($_POST['submit'])) {
			Order::deleteOrderById($orderId);
			
			header('Location: /admin/order/');
		}
		
		require_once(ROOT . '/views/admin_order/delete.php');
		return true;
		
	}		
	
	
	public function actionView($orderId) {
		
		self::checkAdmin();
		
		$order = Order::getOrderById($orderId);
		
		$productsQuantity = json_decode($order['products'], true);
		$productsIds = array_keys($productsQuantity);
		
		$products = Product::getProductsByIds($productsIds);
		
		require_once(ROOT . '/views/admin_order/view.php');
		
		return true;
		
	}
	
	
}

?>