<?php

class Category {
	
	public static function getCategoriesList() {
		
		$db = DB::getConnection();
		
		$categoryList = array();
		
		$result = $db->query('SELECT id, name FROM category WHERE status=1 ORDER BY sort_order ASC');
		
		foreach ($result as $row) {
			$categoryList[] = array('id'   => $row['id'],
											'name' => $row['name']
											);
		}
		
		return $categoryList;
			
	}
	
	
		public static function createCategory($newCategory) {
		
		if (is_array($newCategory)) {
			
			$db = DB::getConnection();
			
			$query = 'INSERT INTO category (name, sort_order, status) VALUES (:name, :sort_order, :status)';
			
			$result = $db->prepare($query);
			$result->bindValue(':name', $newCategory['name']);
			$result->bindValue(':sort_order', $newCategory['sort_order']);
			$result->bindValue(':status', $newCategory['status']);
			
			if ($result->execute())
				return $db->lastInsertId();
			
			return 0;
			
		}
		
	}
	

	public static function getCategoryById($categoryId) {
		
		if ($categoryId) {
			
			$categoryId = intval($categoryId);
			
			$db = DB::getConnection();
			
			$query = 'SELECT * FROM category WHERE id = :categoryId';
			$result = $db->prepare($query);
			$result->bindValue(':categoryId', $categoryId);
			$result->execute();
			$result->setFetchMode(PDO::FETCH_ASSOC);
			
			return $result->fetch();
			
		}
		
	}
	
	
	public static function getCategoriesListAdmin() {
		
		$db = DB::getConnection();
		
		$categoryList = array();
		
		$result = $db->query('SELECT id, name, status, sort_order  FROM category ORDER BY sort_order ASC');
		
		foreach ($result as $row) {
			$categoryList[] = array('id'   => $row['id'],
											'name' => $row['name'],
											'status' => $row['status'],
											'sort_order' => $row['sort_order']
											);
		}
		
		return $categoryList;
			
	}


	public static function deleteCategoryById($categoryId) {
		
		if ($categoryId) {
			
			$categoryId = intval($categoryId);
			
			$db = DB::getConnection();
			
			$query = 'DELETE FROM category WHERE id = :categoryId';
			$result = $db->prepare($query);
			$result->bindValue(':categoryId', $categoryId);
			return $result->execute();
			
		}
		
	}	
	
	
	public static function updateCategoryById($categoryId, $newCategory) {
		
		if ($categoryId) {
			
			$categoryId = intval($categoryId);
			
			$db = DB::getConnection();
			
			$query = 'UPDATE category SET name = :name, sort_order = :sort_order, status = :status WHERE id = :categoryId';
			
			$result = $db->prepare($query);
			$result->bindValue(':name', $newCategory['name']);
			$result->bindValue(':sort_order', $newCategory['sort_order']);
			$result->bindValue(':status', $newCategory['status']);
			$result->bindValue(':categoryId', $categoryId);
			
			return $result->execute();
			
		}
		
	}
	
	
	public static function getStatusText($status) {
		
		$status = intval($status);
		switch ($status) {
			case 1 :
				return 'Visible';
				break;
			case 0 :
				return 'Hide';
				break;
			default :
				return 'Unknown';
				break;
				
		}
		
	}
	
	
}

?>