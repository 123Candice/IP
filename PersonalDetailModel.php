<?php
class PersonalDetailModel extends BaseModel{
	public $firstName = "";
	public $lastName = "";
	public $address1 = "";
	public $address2 = "";
	public $suburb = "";
	public $state = "";
	public $postcode = "";
	public $country = "Australia";
	public $email = "";
	public $mobile = "";
	public $businessPhone = "";
	public $workPhone = "";

	public function validate(){
		foreach($this as $property => $value){
			if ($this->isRequired($property) && $value == "")
				return false;

			if ($value == "") continue;
			$regex = "/^" . $this->getPatternRule($property) . "$/";
			if (preg_match($regex, $value) == 0) return false;
		}
		return true;
	}

	public function isRequired($propertyName){
		switch ($propertyName) {
			case 'firstName':
			case 'lastName':
			case 'address1':
			case 'suburb':
			case 'country':
			case 'email':
				return true;
			case 'state':
			case 'postcode':
				return $this->country == 'Australia';
			default:
				return false;
		}
	}

	public function getPatternRule($propertyName){
		switch ($propertyName) {
			case 'firstName':
			case 'lastName':
				return "[a-zA-Z][a-zA-Z ]+";
			case 'postcode':
				return "\d{4,5}";
			case 'mobile':
			case 'businessPhone':
			case 'workPhone':
				return "\d{10,15}";
			default:
				return ".*";
		}
	}

	public function getPatternMessage($propertyName){
		switch ($propertyName) {
			case 'firstName':
			case 'lastName':
				return "Names cannot start with space or contain numbers/special characters";
			case 'postcode':
				return "Postcode must has 4-5 digits";
			case 'mobile':
			case 'businessPhone':
			case 'workPhone':
				return "Phone number must has 10-15 digits";
			default:
				return "";
		}
	}

	public function __construct($array = array()){
		foreach($array as $key => $value){
			if (property_exists(get_class($this), $key))
				$this->$key = $value;
		}

		$this->variableName = "personalDetail";
	}
}