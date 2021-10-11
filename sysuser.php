<?php

Class Sysuser {
	
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
    
    public function getAllUsers(){
        // get co-workers
        $selector = '0';
        $sql = "SELECT * FROM system_users  where isadmin=?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($selector));
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
	}

	public function getUser($id){
        $sql = "SELECT * FROM system_users WHERE id=?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
    }
    
    public function getUserLogin($username,$password){
        $sql = "SELECT * FROM logins WHERE username=? and password=?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($username,$password));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        
        if(empty($data)){
           return $data;
        }
        else {
        $sql = "SELECT * FROM system_users where username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
        }
	}

    public function updateCustomer($fname, $address, $password, $mail, $contact, $id, $uname){
        $sql = "UPDATE system_users SET fullname=?, address=?, contact=?, email=? WHERE id=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($fname, $address, $contact, $mail, $id));
        return $this->updatePassword($uname, $password);
    }
    
    public function updatePassword($uname, $pwd){
        $sql = "UPDATE logins SET password=? WHERE username=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($pwd, $uname));
        return $status;
	}
    
}
?>