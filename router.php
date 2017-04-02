<?php
// Route URL to corresponding controller/view
class Router{
	private $controller;
	private $action;
	private $id;
	private $additionalRouteData;

	public function getController(){
		return $this->controller;
	}

	public function getAction(){
		return $this->action;
	}

	public function getId(){
		return $this->id;
	}

	public function __construct($url){
		$route = explode("/" , $url);

		$this->controller = (!isset($route[0])||$route[0]==false) ? "home" : "$route[0]";
		$this->action = (!isset($route[1])||$route[1]==false) ? "index" : "$route[1]";
		$this->id = (!isset($route[2])||$route[2]==false) ? null : "$route[2]";

		if (count($route) > 3){
			$this->additionalRouteValues = array_slice($route, 2);
		}

		$this->callController();
	}

	public function callController(){
		// Load base controller
		require_once(CONTROLLER_DIR . "/base_controller.php");

		// Load controller
		$controllerFile  = CONTROLLER_DIR . "/" . $this->controller . "_controller.php";
		if (file_exists($controllerFile)){
			include(CONTROLLER_DIR . "/" . $this->controller . "_controller.php");
		}
		else{
			$controller = new BaseController();
			$this->action = "notFound";
		}

		// Load database
		require_once(APP_DIR . "/connection.php");
		$conn = Connection::getInstance();
		$controller->setConnection($conn);
		$controller->setRouter($this);

		// Execute action
		$controller->executeAction($this->action);
	}

	public static function createURL($controller = null, $action = null, $id = null, $additionalRouteData = null){
		$url = dirname($_SERVER['SCRIPT_NAME']);

		if ($controller == null)
			return $url;
		else 
			$url .= "/$controller";

		if ($action == null)
			return $url;
		else $url .= "/$action";

		if ($id != null)
			$url .= "/$id";
		
		return $url;
	}

	public static function redirect($controller = null, $action=null, $id=null, $additionalRouteData = null){
		$location = router::createURL($controller, $action, $id, $additionalRouteData);

		header('HTTP/1.1 301 Moved Permanently');
		header("Location: $location");
	}
}