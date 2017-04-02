<?php
class BaseModel{
	public $variableName = "base";

	public function isRequired($propertyName){
		return false;
	}

	public function getPatternRule($propertyName){
		return ".*";
	}

	public function getPatternMessage($propertyName){
		return "";
	}

	public function inputFor($propertyName, $attributeMap = array(), $displayValue=true){
		if (!property_exists(get_class($this), $propertyName))
			return "";

		$required = $this->isRequired($propertyName) ? "required" : "";
		$patternRule = $this->getPatternRule($propertyName);
		$patternMessage = $this->getPatternMessage($propertyName);

		$pattern = $patternRule != ".*" ? "pattern='$patternRule' " : "";
		$pattern .= $patternMessage != "" ? "patternError='$patternMessage'" : "";

		$name = $this->variableName . "[$propertyName]";
		$value = $displayValue ? "value='{$this->$propertyName}'" : "";

		$output = "<input type='text' $value name='$name' $required $pattern ";

		foreach ($attributeMap as $key => $value){
			$output .= "$key='$value' ";
		}
		$output .= ">";

		return $output;
	}

	public function emailFor($propertyName, $attributeMap = array(), $displayValue=true){
		if (!property_exists(get_class($this), $propertyName))
			return "";

		$required = $this->isRequired($propertyName) ? "required" : "";
		$patternRule = $this->getPatternRule($propertyName);
		$patternMessage = $this->getPatternMessage($propertyName);

		$pattern = $patternRule != ".*" ? "pattern='$patternRule' " : "";
		$pattern .= $patternMessage != "" ? "patternError='$patternMessage'" : "";

		$name = $this->variableName . "[$propertyName]";
		$value = $displayValue ? "value='{$this->$propertyName}'" : "";

		$output = "<input type='email' $value name='$name' $required $pattern ";

		foreach ($attributeMap as $key => $value){
			$output .= "$key='$value' ";
		}
		$output .= ">";

		return $output;
	}

	public function textAreaFor($propertyName, $attributeMap=array(), $displayValue=true){
		if (!property_exists(get_class($this), $propertyName))
			return "";

		$required = $this->isRequired($propertyName) ? "required" : "";
		$patternRule = $this->getPatternRule($propertyName);
		$patternMessage = $this->getPatternMessage($propertyName);

		$pattern = $patternRule != ".*" ? "pattern='$patternRule' " : "";
		$pattern .= $patternMessage != "" ? "patternError='$patternMessage'" : "";

		$name = $this->variableName . "[$propertyName]";
		$value = $displayValue ? $this->$propertyName : "";

		$output = "<textarea name='$name' $required $pattern ";

		foreach ($attributeMap as $key => $mapValue){
			$output .= "$key='$mapValue' ";
		}
		$output .= ">$value</textarea>";

		return $output;
	}

	public function selectFor($propertyName, $valueList, $attributeMap = array()){

		$required = $this->isRequired($propertyName) ? "required" : "";
		$name = $this->variableName . "[$propertyName]";

		$output = "<select name='$name' $required ";

		foreach ($attributeMap as $key => $value){
			$output .= "$key='$value' ";
		}
		$output .= ">";

		foreach ($valueList as $value) {
			$selected = $value == $this->$propertyName ? "selected" : "";
			$output .= "<option value='$value' $selected>$value</option>";
		}

		$output .= "<select>";

		return $output;
	}
}