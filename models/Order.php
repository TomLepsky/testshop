<?php

class Order {
	
	public static function save($userName, $userPhone, $userComment, $userId, $products) {
		
		$products = json_encode($products);
		
		$db = DB::getConnection();
		
		$query = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';
		
		$result = $db->prepare($query);
		$result->bindValue(':user_name', $userName);
		$result->bindValue(':user_phone', $userPhone);
		$result->bindValue(':user_comment', $userComment);
		$result->bindValue(':user_id', $userId);
		$result->bindValue(':products', $products);
		
		return $result->execute();
		
	}
	
	
	public static function updateOrderById($orderId, $newOrder) {
		
		if ($orderId) {
			
			$orderId = intval($orderId);
			
			$db = DB::getConnection();
			
			$query = 'UPDATE product_order SET user_name = :user_name, user_phone = :user_phone, user_comment = :user_comment, date = :date, status = :status WHERE id = :orderId';
			
			$result = $db->prepare($query);
			$result->bindValue(':user_name', $newOrder['user_name']);
			$result->bindValue(':user_phone', $newOrder['user_phone']);
			$result->bindValue(':status', $newOrder['status']);
			$result->bindValue(':user_comment', $newOrder['user_comment']);
			$result->bindValue(':date', $newOrder['date']);
			$result->bindValue(':orderId', $orderId);
			
			return $result->execute();
			
		}
		
	}	
	
	
	public static function deleteOrderById($orderId) {
		
		if ($orderId) {
			
			$orderId = intval($orderId);
			
			$db = DB::getConnection();
			
			$query = 'DELETE FROM product_order WHERE id = :orderId';
			$result = $db->prepare($query);
			$result->bindValue(':orderId', $orderId);
			return $result->execute();
			
		}
		
	}	
	
	
	public static function getOrdersList() {
		
		$db = DB::getConnection();
		
		$ordersList = array();
		
		$result = $db->query('SELECT * FROM product_order ORDER BY date ASC');
		
		foreach ($result as $row) {
			$ordersList[] = array('id'   		  => $row['id'],
										 'user_name'  => $row['user_name'],
										 'user_phone' => $row['user_phone'],
										 'date'		  => $row['date'],
										 'status'	  => $row['status']
											);
		}
		
		return $ordersList;
	}
	
	
	public static function getOrderById($orderId) {
		
		if ($orderId) {
			
			$orderId = intval($orderId);
			
			$db = DB::getConnection();
			
			$query = 'SELECT * FROM product_order WHERE id = :orderId';
			$result = $db->prepare($query);
			$result->bindValue(':orderId', $orderId);
			$result->execute();
			$result->setFetchMode(PDO::FETCH_ASSOC);
			
			return $result->fetch();
			
		}
		
	}
	
	
	
	
	
	public static function getStatusText($status) {
		
		$status = intval($status);
		switch ($status) {
			case 1 :
				return 'new';
				break;
			case 2 :
				return 'In working';
				break;
			case 3 :
				return 'awaiting delivery';
				break;
			case 4 :
				return 'Done';
				break;
			default :
				return 'Unknown';
				break;
				
		}
		
	}
	
}

?>