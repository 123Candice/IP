<?php
	class Connection{
		private static $instance;
		private $db;

		public static function getInstance(){
			if(Connection::$instance === null){
				Connection::$instance = new Connection();
			}

			return Connection::$instance;
		}

		protected function __construct(){
			$this->db = new PDO('mysql:host=rerun.it.uts.edu.au;dbname=poti', 'potiro', 'pcXZb(kL');
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		private function __clone(){

		}

		private function __wakeup(){

		}

		public function getFlight($routeNo){
			$query = $this->db->prepare("select * from flights where route_no = ?");
			$query->execute(array($routeNo));
			return $query->fetch(PDO::FETCH_ASSOC);
		}

		public function searchFlights($from, $to){
			$from = empty($from) ? "%" : $from;
			$to = empty($to) ? "%" : $to;
			$query = $this->db->prepare("select * from flights where from_city like ? and to_city like ?");
			$query->execute(array("$from", "$to"));

			return $query->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getAllFlyFrom(){
			$query = "select distinct from_city from flights order by from_city asc";
			$result = $this->db->query($query);

			$flights = $result->fetchAll(PDO::FETCH_COLUMN);
			return $flights;
		}

		public function getAllFlyTo(){
			$query = "select distinct to_city from flights order by to_city asc";
			$result = $this->db->query($query);

			$flights = $result->fetchAll(PDO::FETCH_COLUMN);
			return $flights;
		}

		public function getCountryList(){
			$countryList = simplexml_load_file(APP_DIR . "/countries.xml");

			return $countryList;
		}

	}