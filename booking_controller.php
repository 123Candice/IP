<?php
class BookingController extends BaseController{
	public function add(){
		// set view
		$this->viewFile = VIEW_DIR . "/my_booked_flight_view.php";

		// validation
		if(!isset($_POST["route_no"])){
			$this->model["errorMessage"] = "Flight not found";
			return;
		}

		if (!isset($_POST["seat"])){
			$this->model["errorMessage"] = "No seat selected";
			return;
		}

		$routeNo = $_POST["route_no"];
		$seat = $_POST["seat"];

		// get flight
		$flight = $this->connection->getFlight($routeNo);

		if ($flight == null){
			$this->model["errorMessage"] = "Flight not found";
			return;
		}

		// push flight & seats to session
		if (!isset($_SESSION["bookedFlight"]))
			$_SESSION["bookedFlight"] = array();

		$bookedFlight = array();
		$bookedFlight['flightDetail'] = $flight;
		$bookedFlight['seats'] = $seat;

		array_push($_SESSION["bookedFlight"], $bookedFlight);
		
		//$this->model['bookedFlight'] = $_SESSION["bookedFlight"];
		$location = $this->router->createURL("booking", "flights");
		header('HTTP/1.1 301 Moved Permanently');
		header("Location: $location") ;
	}

	public function flights(){
		$this->index(null);
	}

	public function index($viewBooking = true){
		// set view
		$this->viewFile = VIEW_DIR . "/my_booked_flight_view.php";
		$this->model['activeTab'] = $viewBooking ? 'booking' : null;

		if (!isset($_SESSION["bookedFlight"]))
			$_SESSION["bookedFlight"] = array();
		$this->model['bookedFlight'] = $_SESSION["bookedFlight"];
		$this->model['renderSelect'] = $viewBooking;
	}

	public function deleteAll(){
		$_SESSION["bookedFlight"] = array();

		$location = $this->router->createURL("booking", "flights");
		header('HTTP/1.1 301 Moved Permanently');
		header("Location: $location") ;
	}

	public function delete(){

		if (isset($_POST['index'])){
			$index = $_POST['index'];
			$bookedFlights = $_SESSION['bookedFlight'];
			foreach($index as $bookIndex){
				unset($bookedFlights[$bookIndex]);
			}

			$bookedFlights = array_values($bookedFlights);

			$_SESSION['bookedFlight'] = $bookedFlights;
		}

		$location = $this->router->createURL("booking");
		header('HTTP/1.1 301 Moved Permanently');
		header("Location: $location") ;
	}
}

$controller = new BookingController();