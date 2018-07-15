<?php

class Product {
	
	const SHOW_BY_DEFAULT = 3;
	
	public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {
		$count = intval($count);
		
		$db = DB::getConnection();
		
		$productsList = array();
		
		$result = $db->query('SELECT id, name, price, image, is_new FROM product WHERE status=1 ORDER BY id DESC LIMIT ' . $count);

		foreach ($result as $row) {
			$productsList[] = array(
											'id' 	   => $row['id'],
											'name'   => $row['name'],
											'price'  => $row['price'],
											'image'  => $row['image'],
											'is_new' => $row['is_new']
											);
		}
		
		return $productsList;
		
	}
	
	
	public static function getProductsList() {
		
		$db = DB::getConnection();
		
		$productsList = array();
		
		$result = $db->query('SELECT * FROM product  ORDER BY id DESC');

		foreach ($result as $row) {
			$productsList[] = array(
											'id' 	   => $row['id'],
											'name'   => $row['name'],
											'price'  => $row['price'],
											'code'  => $row['code'],
											'is_new' => $row['is_new']
											);
		}
		
		return $productsList;		
	}
	
	
	public static function getRecommendedProducts() {
		
		$db = DB::getConnection();
		$productsList = array();
		
		$result = $db->query('SELECT id, name, price, image, is_new FROM product WHERE status = 1 AND is_recommended = 1');
		
		foreach ($result as $row) {
			$productsList[] = array(
											'id' 	   => $row['id'],
											'name'   => $row['name'],
											'price'  => $row['price'],
											'image'  => $row['image'],
											'is_new' => $row['is_new']
											);
		}
		
		return $productsList;
		
	}
	
	
	public static function getProductsListByCategory($categoryId = false, $page) {
		
		if ($categoryId) {
			
			$categoryId = intval($categoryId);
			
			if (!is_int($page))
				$page = 1;
			
			$db = DB::getConnection();
			
			$productsList = array();
			
			$result = $db->query('SELECT id, name, price, image, is_new from product where status=1 AND category_id = ' . $categoryId . ' ORDER BY id DESC LIMIT ' . self::SHOW_BY_DEFAULT . ' OFFSET ' . ($page - 1) * self::SHOW_BY_DEFAULT);
			
			foreach ($result as $row) {
				$productsList[] = array(
											'id' 	   => $row['id'],
											'name'   => $row['name'],
											'price'  => $row['price'],
											'image'  => $row['image'],
											'is_new' => $row['is_new']
											);								
			}
			
			return $productsList;
		}
		
	}
	
	
	public static function getProductById($productId) {
		
	if ($productId) {
			$productId = intval($productId);
		
			$db = DB::getConnection();
			
			$productsList = array();
			
			$result = $db->query('SELECT * from product WHERE id = ' . $productId);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			
			return $result->fetch();
			
		}
		
	}
	
	
	public static function getTotalProductsInCategory($categoryId) {
		
		$db = DB::getConnection();
		
		$result = $db->query('SELECT count(id) as count FROM product WHERE status = 1 AND category_id = ' . $categoryId);
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$row = $result->fetch();
		
		return $row['count'];
		
	}
	
	
	public static function getProductsByIds($productsIds) {
		
		$products = array();
		
		if (is_array($productsIds)) {
			$db = DB::getConnection();
			
			foreach ($productsIds as $id) {
				$query = 'SELECT * FROM product WHERE id = :id';
				$result = $db->prepare($query);
				$result->bindValue(':id', $id);
				$result->execute();
				$result = $result->fetch();
				$products[] = array('id' => $result['id'],
										  'code' => $result['code'],
										  'name' => $result['name'],
										  'price' => $result['price']
										  );

			}
			
			return $products;
			
		}
		
	}
	
	
	public static function deleteProductById($productId) {
		
		if ($productId) {
			
			$productId = intval($productId);
			
			$db = DB::getConnection();
			
			$query = 'DELETE FROM product WHERE id = :productId';
			$result = $db->prepare($query);
			$result->bindValue(':productId', $productId);
			return $result->execute();
			
		}
		
	}
	
	
	public static function updateProductById($productId, $newProduct) {
		
		if ($productId) {
			
			$productId = intval($productId);
			
			$db = DB::getConnection();
			
			$query = 'UPDATE product SET name = :name, code = :code, price = :price, category_id = :category_id, brand = :brand, availability = :availability, description = :description, is_new = :is_new, is_recommended = :is_recommended, status = :status WHERE id = :productId';
			
			$result = $db->prepare($query);
			$result->bindValue(':name', $newProduct['name']);
			$result->bindValue(':code', $newProduct['code']);
			$result->bindValue(':price', $newProduct['price']);
			$result->bindValue(':category_id', $newProduct['category_id']);
			$result->bindValue(':brand', $newProduct['brand']);
			$result->bindValue(':availability', $newProduct['availability']);
			$result->bindValue(':description', $newProduct['description']);
			$result->bindValue(':is_new', $newProduct['is_new']);
			$result->bindValue(':is_recommended', $newProduct['is_recommended']);
			$result->bindValue(':status', $newProduct['status']);
			$result->bindValue(':productId', $productId);
			
			return $result->execute();
			
		}
		
	}
	
	
	public static function createProduct($newProduct) {
		
		if (is_array($newProduct)) {
			
			$db = DB::getConnection();
			
			$query = 'INSERT INTO product (name, code, price, category_id, brand, availability, description, is_new, is_recommended, status) VALUES (:name, :code, :price, :category_id, :brand, :availability, :description, :is_new, :is_recommended, :status)';
			
			$result = $db->prepare($query);
			$result->bindValue(':name', $newProduct['name']);
			$result->bindValue(':code', $newProduct['code']);
			$result->bindValue(':price', $newProduct['price']);
			$result->bindValue(':category_id', $newProduct['category_id']);
			$result->bindValue(':brand', $newProduct['brand']);
			$result->bindValue(':availability', $newProduct['availability']);
			$result->bindValue(':description', $newProduct['description']);
			$result->bindValue(':is_new', $newProduct['is_new']);
			$result->bindValue(':is_recommended', $newProduct['is_recommended']);
			$result->bindValue(':status', $newProduct['status']);
			
			if ($result->execute())
				return $db->lastInsertId();
			
			return 0;
			
		}
	}
	
	
   public static function getImage($id) {

      $noImage = 'no-image.jpg';

      $path = '/upload/images/products/';

      $pathToProductImage = $path . $id . '.jpg';

      if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) 
			return $pathToProductImage;

      return $path . $noImage;
		
    }
	
	
}

?>