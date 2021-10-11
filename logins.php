<?php

Class Logins {
	
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

	public function getCustomer($id){
        // get customer details
        $sql = "SELECT * FROM customer where id = ?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($id));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
	}

	public function getUser($username,$password){
        $sql = "SELECT * FROM logins WHERE username=? and password=?";
        $stmt = $this->db->prepare($sql); 
        $stmt->execute(array($username,$password));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        
        if(empty($data)){
           return $data;
        }
        else {
        $sql = "SELECT * FROM customer where username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username));
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        return $data;
        }
	}

	public function createCustomer($fname, $address, $uname, $password, $mail, $contact){
        $sql = "INSERT INTO customer (fullname, address, contact, email, username) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($fname, $address, $contact, $mail, $uname));

        $sql = "INSERT INTO logins ( username, password, utype) VALUES (?,?,?)";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($uname, $password, 'customer'));
        return $status;
	}

	public function updateCustomer($fname, $address, $password, $mail, $contact, $id, $uname){
        $sql = "UPDATE customer SET fullname=?, address=?, contact=?, email=? WHERE id=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($fname, $address, $contact, $mail, $id));
        if(!empty($password)) updatePassword($uname, $password); 
        return $status;
        }
        
        public function updatePassword($uname, $pwd){
        $sql = "UPDATE logins SET password=? WHERE username=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($pwd, $uname));
        return $status;
        }

	public function deleteBarang($idBarang){
        $sql = "DELETE FROM barang WHERE idBarang=?";
        $stmt = $this->db->prepare($sql); 
        $status = $stmt->execute(array($idBarang));
        return $status;
        }
        
        public function resetPassword($mail) {    
        $sql = "SELECT username FROM customer where email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($mail));
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return  updatePassword($data,$randomString);
        }
}
?>