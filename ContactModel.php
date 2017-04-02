<?php
class ContactModel extends BaseModel{
	public $subject="";
	public $email="";
	public $firstName="";
	public $lastName="";
	public $message="";

	public function isRequired($propertyName){
		if ($propertyName == "firstName" || $propertyName == "lastName")
			return false;
		
		return true;
	}

	public function getPatternRule($propertyName){
		if ($propertyName == 'firstName' || $propertyName == 'lastName')
			return "[a-zA-Z][a-zA-Z ]+";

		return ".*";
	}

	public function getPatternMessage($propertyName){
		if ($propertyName == 'firstName' || $propertyName == 'lastName'){
			return "Names cannot start with space or contain numbers/special characters";
		}

		return "";
	}

	public function validate(){
		foreach($this as $property => $value){
			if ($this->isRequired($property) && $value == "")
				return false;
		}

		return true;
	}

	public function __construct($array = array()){
		foreach($array as $key => $value){
			if (property_exists(get_class($this), $key))
				$this->$key = $value;
		}

		$this->variableName = "contact";
	}
}