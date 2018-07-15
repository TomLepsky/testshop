<?php

class AdminCategoryController extends Admin {
	
	public function actionIndex() {
		
		self::checkAdmin();
		
		$categoriesList = array();
		$categoriesList = Category::getCategoriesListAdmin();
		
		require_once(ROOT . '/views/admin_category/index.php');
		
		return true;
		
	}


	public function actionUpdate($categoryId) {
		
		self::checkAdmin();
		
		$category = Category::getCategoryById($categoryId);
		
		if (isset($_POST['submit'])) {
			
			$newCategory['name'] = $_POST['name'];
			$newCategory['sort_order'] = $_POST['sort_order'];
			$newCategory['status'] = $_POST['status'];	
			
			$errors = false;
			
			if (!isset($newCategory['name']) || empty($newCategory['name'])) 
				$errors[] = 'wrong data';
			
			if ($errors == false) {
				Category::updateCategoryById($categoryId, $newCategory);

				header('Location: /admin/category');
			}
			
		}
		
		require_once(ROOT . '/views/admin_category/update.php');
		
		return true;
		
	}

	
	public function actionCreate() {
		
		self::checkAdmin();
		
		if (isset($_POST['submit'])) {
			
			$newCategory['name'] = $_POST['name'];
			$newCategory['sort_order'] = $_POST['sort_order'];
			$newCategory['status'] = $_POST['status'];
			
			$errors = false;
			
			if (!isset($newCategory['name']) || empty($newCategory['name'])) 
				$errors[] = 'Empty or wrong field!! >_<';
			
			if ($errors == false) {
				
				Category::createCategory($newCategory);

				header('Location: /admin/category');
				
			}
			
		}
		require_once(ROOT . '/views/admin_category/create.php');
		
		return true;
	}
	
	
	public function actionDelete($categoryId) {
		
		self::checkAdmin();
		
		if (isset($_POST['submit'])) {
			Category::deleteCategoryById($categoryId);
			
			header('Location: /admin/category/');
		}
		
		require_once(ROOT . '/views/admin_category/delete.php');
		return true;
		
	}	
	
}

?>