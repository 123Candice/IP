<?php
class BaseController{
	protected $viewFile = "";
	protected $connection = null;
	protected $model = null;
	protected $template = null;
	protected $router = null;

	public function getViewFile(){
		return $this->viewFile;
	}

	public function setConnection($connection){
		$this->connection = $connection;
	}

	public function getModel(){
		return $this->model;
	}

	public function __construct(){
		$this->model = array();
		$this->template = VIEW_DIR . "/template.php";
	}

	public function setRouter($router){
		$this->router = $router;
	}

	public function executeAction($action){
		// execute action
		if (method_exists($this, $action))
			$this->$action();
		else $this->notFound();

		$controller = $this;
		$model = $this->model;
		$router = $this->router;

		// call template
		if ($this->template != null){
			if (file_exists($this->template))
				require_once($this->template);
			else $this->notFound();
		} else if ($this->getViewFile() != null){
			if (file_exists($this->viewFile))
				require_once($this->viewFile);
			else $this->notFound();
		}
	}

	protected function notFound(){
		$this->viewFile = VIEW_DIR . "/page_not_found_view.php";
	}
}