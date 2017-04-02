<?php
class PaymentDetailModel extends BaseModel{
	public $cardType = "";
	public $cardName = "";
	public $cardNumber = "";
	public $expireMonth = "";
	public $expireYear = "";
	public $securityCode = "";

	private function validateExpireDate(){
		if ((int)$this->expireYear < (int)date("Y")) return false;
		if ($this->expireYear == date("Y") && (int)$this->expireMonth < (int)date("m")) return false;

		return true;
	}

	public function validate(){
		foreach($this as $property => $value){
			if ($this->isRequired($property) && $value == "")
				return false;

			if ($value == "") continue;
			$regex = "/^" . $this->getPatternRule($property) . "$/";
			if (preg_match($regex, $value) == 0) return false;
		}

		if ($this->validateExpireDate() == false)
			return false;

		return true;
	}

	public function isRequired($propertyName){
		return true;
	}

	public function getPatternRule($propertyName){
		switch ($propertyName) {
			case 'cardName':
				return "[a-zA-Z][a-zA-Z ]+";
			case 'cardNumber':
				return "\d{12}";
			case 'securityCode':
				return "\d{3}";
			default:
				return ".*";
		}
	}

	public function getPatternMessage($propertyName){
		switch ($propertyName) {
			case 'cardName':
				return "Names cannot start with space or contain numbers/special characters";
			case 'cardNumber':
				return "Credit card number must have 12 digits";
			case 'securityCode':
				return "Security code must have 3 digits";
			default:
				return "";
		}
	}

	public function __construct($array = array()){
		foreach($array as $key => $value){
			if (property_exists(get_class($this), $key))
				$this->$key = $value;
		}

		$this->variableName = "paymentDetail";
	}
}