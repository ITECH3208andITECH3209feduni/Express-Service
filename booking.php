<?php

Class Booking {
	
	public function __construct(){
		$this->db = $this->getDB();
	}

	// Connect Database
	private function getDB() {
		$dbhost="localhost";
		$dbuser="root";
		$dbpass="@123456";
		$dbname="service";

		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}

	public function getAllBookings(){
        $sql = "SELECT * FROM booking ORDER BY date ASC";
        $stmt = $this->db->query($sql); 
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
	}

	public function getBooking($id){
        $sql = "SELECT * FROM booking WHERE id=?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
	}

	public function insertBooking($customer, $driver, $status, $total, $pickupdate){
        $sql = "INSERT INTO booking (customer, driver, status, total, pickup) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($customer, $driver, $status, $total, $pickupdate));
        return $status;
	}

	public function updateBooking($id, $driver, $status, $pickupdate){
        $sql = "UPDATE booking SET driver=?, status=? WHERE id=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($driver, $status, $id));
        return $status;
	}

	public function deleteBooking($id){
        $sql = "DELETE FROM booking WHERE id=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($id));
        return $status;
	}
}
?>