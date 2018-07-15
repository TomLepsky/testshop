<?php

class AdminProductController extends Admin {

	public function actionIndex() {
		
		self::checkAdmin();
		
		$productsList = Product::getProductsList();
		
		require_once(ROOT . '/views/admin_product/index.php');
		return true;
		
	}
	
	
	//add a new product
	public function actionCreate() {
		
		self::checkAdmin();
		
		$categoriesList = Category::getCategoriesListAdmin();
		
		if (isset($_POST['submit'])) {
			
			$newProduct['name'] = $_POST['name'];
			$newProduct['code'] = $_POST['code'];
			$newProduct['price'] = $_POST['price'];
			$newProduct['category_id'] = $_POST['category_id'];
			$newProduct['brand'] = $_POST['brand'];
			$newProduct['availability'] = $_POST['availability'];
			$newProduct['description'] = $_POST['description'];
			$newProduct['is_new'] = $_POST['is_new'];
			$newProduct['is_recommended'] = $_POST['is_recommended'];
			$newProduct['status'] = $_POST['status'];

			
			$errors = false;
			
			if (!isset($newProduct['name']) || empty($newProduct['name'])) 
				$errors[] = 'Empty or wrong field!! >_<';
			
			if ($errors == false) {
				
				$newProductId = Product::createProduct($newProduct);
				
				if ($newProductId) {
					
					if (is_uploaded_file($_FILES['image']['tmp_name']))
						move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$newProductId}.jpg");
				}
				
				header('Location: /admin/product');
				
			}
			
		}
		require_once(ROOT . '/views/admin_product/create.php');
		
		return true;
	}
	
	
	public function actionUpdate($productId) {
		
		self::checkAdmin();
		
		$categoriesList = Category::getCategoriesListAdmin();
		
		$product = Product::getProductById($productId);
		
		if (isset($_POST['submit'])) {
			
			$newProduct['name'] = $_POST['name'];
			$newProduct['code'] = $_POST['code'];
			$newProduct['price'] = $_POST['price'];
			$newProduct['category_id'] = $_POST['category_id'];
			$newProduct['brand'] = $_POST['brand'];
			$newProduct['availability'] = $_POST['availability'];
			$newProduct['description'] = $_POST['description'];
			$newProduct['is_new'] = $_POST['is_new'];
			$newProduct['is_recommended'] = $_POST['is_recommended'];
			$newProduct['status'] = $_POST['status'];	
			
			
			$errors = false;
			
			if (!isset($newProduct['name']) || empty($newProduct['name'])) 
				$errors[] = 'wrong data';
			
			if ($errors == false) {
				if (Product::updateProductById($productId, $newProduct)) {
					
					if (is_uploaded_file($_FILES['image']['tmp_name']))
						move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$productId}.jpg");
				}
				
			}

			header('Location: /admin/product');
			
		}
		
		require_once(ROOT . '/views/admin_product/update.php');
		
		return true;
		
	}
	
	
	public function actionDelete($productId) {
		
		self::checkAdmin();
		
		if (isset($_POST['submit'])) {
			Product::deleteProductById($productId);
			
			header('Location: /admin/product/');
		}
		
		require_once(ROOT . '/views/admin_product/delete.php');
		return true;
		
	}

}

?>