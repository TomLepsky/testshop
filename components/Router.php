<?php

class Router {

	private $routes = array();
	
	public function __construct() {
		$routesPath = ROOT . '/config/routes.php';
		$this->routes = include($routesPath);
	}
	
	public function run() {
		//  $uri = news/123
		$uri = $this->getURI();

		foreach ($this->routes as $uriPattern => $path) {
			
			if (preg_match("~($uriPattern)~", $uri)) {
				
				//$internalRoute = news/view/123
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				$segments = explode('/', $internalRoute);

				$controllerName = ucfirst(array_shift($segments)) . 'Controller';
				$actionName = 'action' . ucfirst(array_shift($segments));
				
				$parameters = $segments;
				
				$controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

				if (file_exists($controllerFile)) {
					
					include_once($controllerFile);
				
					$controllerObject = new $controllerName;
					
					//call_user_func_array позволяет получать массив как набор отдельных именых переменных
					$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
					
					if ($result != null) 
						break;
					
				}	
				
			}
			
		}
		
	}
	
	/**
	 * Returns request string
	 * @return string
	 */
	private function getURI() {
		if (!empty($_SERVER['REQUEST_URI']))
			return trim($_SERVER['REQUEST_URI'], '/');
	}

}

?>