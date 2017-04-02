<?php
class HomeController extends BaseController{
	public function index(){
		$this->model['activeTab'] = 'home';
		$this->viewFile = VIEW_DIR . "/home_view.php";
	}

	public function contact(){
		$this->model['activeTab'] = 'contact';
		$this->viewFile = VIEW_DIR . "/contact_view.php";

		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->model['contact'] = new ContactModel($_POST["contact"]);
			if ($this->model['contact']->validate() == false){
				$this->model['errorMessage'] = "Invalid form";
				return;
			}

			try{
				$to = "Cuu.S.Dang@student.uts.edu.au";
				$subject = $this->model['contact']->subject;
				$message = $this->model['contact']->message;
				$senderEmail = $this->model['contact']->email;
				$senderName = $this->model['contact']->firstName . " " . $this->model['contact']->lastName;

				$headers = "From: $senderName <$senderEmail>";

				mail($to, $subject, $message, $headers);
				$this->model['success'] = true;
				$this->model['contact'] = new ContactModel();
				header('HTTP/1.1 301 Moved Permanently');
				return;

			}catch (Exception $ex){
				$this->model['errorMessage'] = "Error occured when sending email";
				return;
			}
		}
	}
}

$controller = new HomeController();