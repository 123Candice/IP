<?php

class CheckoutController extends BaseController{
	public function progress(){
		$this->template = null;
		$this->viewFile = VIEW_DIR . "/partials/checkout_progress_view.php";
	}

	private function validateBookedFlight(){
		if (!isset($_SESSION['bookedFlight']))
			$_SESSION['bookedFlight'] = array();

		return count($_SESSION['bookedFlight']) > 0;
	}

	private function findStep(){
		$step = 0;
		if ($this->validateBookedFlight() == false) return $step;
		$step++;

		$personalDetail = isset($_SESSION['personalDetail']) ? $_SESSION['personalDetail'] : new PersonalDetailModel();
		if ($personalDetail->validate() == false) return $step;

		$step++;
		$paymentDetail = isset($_SESSION['paymentDetail']) ? $_SESSION['paymentDetail'] : new PersonalDetailModel();
		if ($paymentDetail->validate() == false) return $step;

		$step++;
		return $step;
	}

	public function index(){
		return $this->step1();
	}

	public function step1(){
		$this->viewFile = VIEW_DIR . "/checkout_step1_view.php";
		$this->model['step'] = 1;

		if ($this->validateBookedFlight() == false){
			$this->model['errorMessage'] = 'You have no booked flight';
			return;
		}

		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			$personalDetail = new PersonalDetailModel($_POST['personalDetail']);
			if ($personalDetail->validate() == true){
				$_SESSION['personalDetail'] = $personalDetail;
				router::redirect("checkout", "step2");
				return;
			}
		}

		if (isset($_SESSION["personalDetail"])){
			$this->model['personalDetail'] = $_SESSION["personalDetail"];
		} else $this->model['personalDetail'] = new PersonalDetailModel();

		$this->model['countryList'] = $this->connection->getCountryList();
	}

	public function step2(){
		$this->viewFile = VIEW_DIR ."/checkout_step2_view.php";
		$this->model['step'] = 2;

		// server side validation
		if ($this->validateBookedFlight() == false){ $this->model['errorMessage'] = 'You have no booked flight'; return; }

		$personalDetail = isset($_SESSION['personalDetail'])? $_SESSION['personalDetail'] : new PersonalDetailModel();
		if ($personalDetail->validate() == false){ $this->model['errorMessage'] = "Invalid personal detail, please edit your detail in step 1"; return;}
		// end validation

		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			$paymentDetail = new PaymentDetailModel($_POST['paymentDetail']);
			if ($paymentDetail->validate() == true){
				$_SESSION['paymentDetail'] = $paymentDetail;
				router::redirect("checkout", "step3");
				return;
			}
		}

		$this->model['personalDetail'] = $personalDetail;

		if (isset($_SESSION['paymentDetail']))
			$this->model['paymentDetail'] = $_SESSION['paymentDetail'];
		else $this->model['paymentDetail'] = new PaymentDetailModel();
	}

	public function step3(){
		$this->viewFile = VIEW_DIR ."/checkout_step3_view.php";
		$this->model['step'] = 3;

		// server side validation
		if ($this->validateBookedFlight() == false){ $this->model['errorMessage'] = 'You have no booked flight'; return;}

		$personalDetail = isset($_SESSION['personalDetail']) ? $_SESSION['personalDetail'] : new PersonalDetailModel();
		if ($personalDetail->validate() == false){ $this->model['errorMessage'] = "Invalid personal detail, please edit your detail in step 1"; return;}

		$paymentDetail = isset($_SESSION['paymentDetail']) ? $_SESSION['paymentDetail'] : new PaymentDetailModel();
		if ($paymentDetail->validate() == false){ $this->model['errorMessage'] = "Invalid payment detail, please edit your detail in step 2"; return;}
		// end validation

		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->sendEmail();
			router::redirect("checkout", "step4");
			return;
		}

		$this->model['personalDetail'] = $personalDetail;
		$this->model['paymentDetail'] = $paymentDetail;
		$this->model['bookedFlight'] = $_SESSION['bookedFlight'];
	}

	private function sendEmail(){
		try{
			$personalDetail = isset($_SESSION['personalDetail']) ? $_SESSION['personalDetail'] : new PersonalDetailModel();
			$paymentDetail = isset($_SESSION['paymentDetail']) ? $_SESSION['paymentDetail'] : new PaymentDetailModel();
			$bookedFlight = isset($_SESSION['bookedFlight']) ? $_SESSION['bookedFlight'] : array();

			if (count($bookedFlight) == 0) return;
			if ($paymentDetail->validate() == false || $personalDetail->validate() == false) return;

			ob_start();
			$emailTemplateFile = APP_DIR . "/email_template.php";
			require $emailTemplateFile;
			$emailContent = ob_get_contents();
			ob_end_clean();

			$to = $personalDetail->email;
			$subject = "Your flight booking detail - Online travel agency";

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			mail($to,$subject,$emailContent,$headers);
			$_SESSION["emailSent"] = true;
			$_SESSION["bookedFlight"] = array();
			$_SESSION["personalDetail"] = new PersonalDetailModel();
			$_SESSION["paymentDetail"] = new PaymentDetailModel();
		} catch (Exception $ex){
			return;
		}
	}

	public function step4(){
		$this->viewFile = VIEW_DIR . "/checkout_step4_view.php";
		$this->model['step'] = 4;

		$emailSent = isset($_SESSION['emailSent']) ? $_SESSION['emailSent'] : false;
		//$emailSent = true;
		if (!$emailSent){
			$personalDetail = isset($_SESSION['personalDetail']) ? $_SESSION['personalDetail'] : new PersonalDetailModel();
			$paymentDetail = isset($_SESSION['paymentDetail']) ? $_SESSION['paymentDetail'] : new PaymentDetailModel();
			$bookedFlight = isset($_SESSION['bookedFlight']) ? $_SESSION['bookedFlight'] : array();

			if (count($bookedFlight) == 0){ $this->model["errorMessage"] = "You have no booked flight"; return; }
			if ($personalDetail->validate() == false) { $this->model['errorMessage'] = "Invalid personal detail, please edit your detail in step 1"; return; }
			if ($paymentDetail->validate() == false){ $this->model['errorMessage'] = "Invalid payment detail, please edit your detail in step 2"; return;}
			$this->model['errorMessage'] = "Error occured!";
			return;
		} else {
			$_SESSION['emailSent'] = false;
		}
	}
}

$controller = new CheckoutController();