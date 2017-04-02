<?php
class FlightController extends BaseController {

	public function search(){
		// set view
		$this->viewFile = VIEW_DIR . "/search_view.php";

		$this->model["activeTab"] = 'search';
		$this->model["flyFromList"] = $this->connection->getAllFlyFrom();
		$this->model["flyToList"] = $flyToList = $this->connection->getAllFlyTo();

		// search flights
		$this->model["isSearch"] = true;
		$this->model["from"] = isset($_GET["from"]) ? $_GET["from"] : "";
		$this->model["to"] = isset($_GET["to"]) ? $_GET["to"] : "";

		if (empty($this->model["from"]) && empty($this->model["to"]))
			$this->model["isSearch"] = false;

		if ($this->model["isSearch"]){
			$this->model["searchResult"] = $this->connection->searchFlights($this->model["from"], $this->model["to"]);
		}
	}

	public function book(){
		// set view
		$this->viewFile = VIEW_DIR . "/book_flight_view.php";

		$flight = isset($_GET["route_no"]) ? $this->connection->getFlight($_GET["route_no"]) : null;

		$this->model["errorMessage"] = $flight ? null : "Flight not found";
		$this->model["flight"] = $flight;
	}

	public function addToBooking(){

	}
}

$controller = new FlightController();