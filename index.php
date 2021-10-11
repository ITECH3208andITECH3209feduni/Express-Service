<?php

function deliver_response($response){
	// Define HTTP responses
	$http_response_code = array(
		100 => 'Continue',  
		101 => 'Switching Protocols',  
		200 => 'OK',
		201 => 'Created',  
		202 => 'Accepted',  
		203 => 'Non-Authoritative Information',  
		204 => 'No Content',  
		205 => 'Reset Content',  
		206 => 'Partial Content',  
		300 => 'Multiple Choices',  
		301 => 'Moved Permanently',  
		302 => 'Found',  
		303 => 'See Other',  
		304 => 'Not Modified',  
		305 => 'Use Proxy',  
		306 => '(Unused)',  
		307 => 'Temporary Redirect',  
		400 => 'Bad Request',  
		401 => 'Unauthorized',  
		402 => 'Payment Required',  
		403 => 'Forbidden',  
		404 => 'Not Found',  
		405 => 'Method Not Allowed',  
		406 => 'Not Acceptable',  
		407 => 'Proxy Authentication Required',  
		408 => 'Request Timeout',  
		409 => 'Conflict',  
		410 => 'Gone',  
		411 => 'Length Required',  
		412 => 'Precondition Failed',  
		413 => 'Request Entity Too Large',  
		414 => 'Request-URI Too Long',  
		415 => 'Unsupported Media Type',  
		416 => 'Requested Range Not Satisfiable',  
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',  
		501 => 'Not Implemented',  
		502 => 'Bad Gateway',  
		503 => 'Service Unavailable',  
		504 => 'Gateway Timeout',  
		505 => 'HTTP Version Not Supported'
		);

	// Set HTTP Response
	header('HTTP/1.1 '.$response['status'].' '.$http_response_code[ $response['status'] ]);
	// Set HTTP Response Content Type
	header('Content-Type: application/json; charset=utf-8');
	// Format data into a JSON response
	$json_response = json_encode($response['data']);
	// Deliver formatted data
	echo $json_response;

	exit;
}


// Set default HTTP response of 'Not Found'
$response['status'] = 404;
$response['data'] = NULL;

$url_array = explode('/', $_SERVER['REQUEST_URI']);
array_shift($url_array); // remove first value as it's empty
// remove 2nd and 3rd array, because it's directory
array_shift($url_array); // 2nd = 'NativeREST'
array_shift($url_array); // 3rd = 'api'

// get the action (resource, collection)
$action = $url_array[0];
// get the method
$method = $_SERVER['REQUEST_METHOD'];

require_once("barang.php");
require_once("logins.php");
require_once("booking.php");
require_once("sysuser.php");
if( strcasecmp($action,'barang') == 0){
	$barang = new Barang();
	if($method=='GET'){
		if(!isset($url_array[1])){ // if parameter idBarang not exist
			// METHOD : GET api/barang
			$data=$barang->getAllBarang();
			$response['status'] = 200;
			$response['data'] = $data;
		}else{ // if parameter idBarang exist
			// METHOD : GET api/barang/:idBarang
			$idBarang=$url_array[1];
			$data=$barang->getBarang($idBarang);
			
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Barang tidak ditemukan');	
			}else{
				$response['status'] = 200;
				$response['data'] = $data;	
			}
		}
	}
	elseif($method=='POST'){
		// METHOD : POST api/barang
		// get post from client
		$json = file_get_contents('php://input');
		$post = json_decode($json); // decode to object

		// check input completeness
		if($post->namaBarang=="" || $post->kategori=="" || $post->stok=="" || $post->hargaBeli=="" || $post->hargaJual==""){
			$response['status'] = 400;
			$response['data'] = array('error' => 'Data tidak lengkap');
		}else{
			$status = $barang->insertBarang($post->namaBarang, $post->kategori, $post->stok, $post->hargaBeli, $post->hargaJual);
			if($status==1){
				$response['status'] = 201;
				$response['data'] = array('success' => 'Data berhasil disimpan');
			}else{
				$response['status'] = 400;
				$response['data'] = array('error' => 'Terjadi kesalahan');
			}
		}
	}
	elseif($method=='PUT'){
		// METHOD : PUT api/barang/:idBarang
		if(isset($url_array[1])){
			$idBarang = $url_array[1];
			// check if idBarang exist in database
			$data=$barang->getBarang($idBarang);
			if(empty($data)) { 
				$response['status'] = 404;
				$response['data'] = array('error' => 'Data tidak ditemukan');	
			}else{
				// get post from client
				$json = file_get_contents('php://input');
				$post = json_decode($json); // decode to object

				// check input completeness
				if($post->namaBarang=="" || $post->kategori=="" || $post->stok=="" || $post->hargaBeli=="" || $post->hargaJual==""){
					$response['status'] = 400;
					$response['data'] = array('error' => 'Data tidak lengkap');
				}else{
					$status = $barang->updateBarang($idBarang, $post->namaBarang, $post->kategori, $post->stok, $post->hargaBeli, $post->hargaJual);
					if($status==1){
						$response['status'] = 200;
						$response['data'] = array('success' => 'Data berhasil diedit');
					}else{
						$response['status'] = 400;
						$response['data'] = array('error' => 'Terjadi kesalahan');
					}
				}
			}
		}
	}
	elseif($method=='DELETE'){
		// METHOD : DELETE api/barang/:idBarang
		if(isset($url_array[1])){
			$idBarang = $url_array[1];
			// check if idBarang exist in database
			$data=$barang->getBarang($idBarang);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Data tidak ditemukan');	
			}else{
				$status = $barang->deleteBarang($idBarang);
				if($status==1){
					$response['status'] = 200;
					$response['data'] = array('success' => 'Data berhasil dihapus');
				}else{
					$response['status'] = 400;
					$response['data'] = array('error' => 'Terjadi kesalahan');
				}
			}
		}
	}
}

if( strcasecmp($action,'login') == 0){
	$barang = new Logins();
	if($method=='GET'){
		if(!isset($url_array[2]) && isset($url_array[1]) ){ // if parameter idBarang not exist
			
			$data=$barang->getCustomer($url_array[1]);
			$response['status'] = 200;
			$response['data'] = $data;
		}else{ // if parameter idBarang exist
			// METHOD : GET api/barang/:idBarang
			$user=$url_array[1];
			$password=$url_array[2];
			$data=$barang->getUser($user,$password);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Wrong Credentials!');	
			}else{
				$response['status'] = 200;
				$response['data'] = $data;	
			}
		}
	}
	elseif($method=='POST'){
		// METHOD : POST api/barang
		// get post from client
		$json = file_get_contents('php://input');
		$post = json_decode($json); // decode to object

		// check input completeness
		if($post->fname=="" || $post->contact=="" || $post->mail=="" || $post->pwd=="" || $post->address=="" || $post->uname=="" ){
			$response['status'] = 400;
			$response['data'] = array('error' => 'Incomplete Data!');
		}
		else{
			$status = $barang->createCustomer($post->fname, $post->address, $post->uname, $post->pwd, $post->mail, $post->contact);
			if($status==1){
				$response['status'] = 201;
				$response['data'] = array('success' => 'Customer Signup Successfully!');
			}else{
				$response['status'] = 400;
				$response['data'] = array('error' => 'Something went wrong!');
			}
		}
	}
	elseif($method=='PUT'){
		// METHOD : PUT api/barang/:idBarang
		if(isset($url_array[1])){
			$status = $barang->resetPassword($url_array[1]);
			if($status==1){
				$response['status'] = 200;
				$response['data'] = array('success' => 'Password Reset Successfully!');
			}else{
				$response['status'] = 400;
				$response['data'] = array('error' => 'Something Went Wrong!');
			}
		}

			// check if idBarang exist in database
			
				// get post from client
				$json = file_get_contents('php://input');
				$post = json_decode($json); // decode to object

				// check input completeness
				if($post->fname=="" || $post->contact=="" || $post->mail=="" || $post->pwd=="" || $post->address=="" || $post->id=="" ){
					$response['status'] = 400;
					$response['data'] = array('error' => 'Missing Required Data');
				}else{
					$status = $barang->updateCustomer($post->fname, $post->address, $post->pwd, $post->mail, $post->contact, $post->id, $post->uname );
					if($status==1){
						$response['status'] = 200;
						$response['data'] = array('success' => 'Customer Updated Successfully!');
					}else{
						$response['status'] = 400;
						$response['data'] = array('error' => 'Something Went Wrong!');
					}
				}
	}
	elseif($method=='DELETE'){
		// METHOD : DELETE api/barang/:idBarang
		if(isset($url_array[1])){
			$idBarang = $url_array[1];
			// check if idBarang exist in database
			$data=$barang->getBarang($idBarang);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Data tidak ditemukan');	
			}else{
				$status = $barang->deleteBarang($idBarang);
				if($status==1){
					$response['status'] = 200;
					$response['data'] = array('success' => 'Data berhasil dihapus');
				}else{
					$response['status'] = 400;
					$response['data'] = array('error' => 'Terjadi kesalahan');
				}
			}
		}
	}
}


// booking section
if( strcasecmp($action,'booking') == 0){
	$booking = new Booking();
	if($method=='GET'){
		if(!isset($url_array[1])){ // if parameter id not exist
			// METHOD : GET api/barang
			$data=$booking->getAllBookings();
			$response['status'] = 200;
			$response['data'] = $data;
		}else{ // if parameter idBarang exist
			// METHOD : GET api/booking/:id
			$id = $url_array[1];
			$data=$booking->getBooking($id);
			
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Booking not available!');	
			}else{
				$response['status'] = 200;
				$response['data'] = $data;	
			}
		}
	}
	elseif($method=='POST'){
		// METHOD : POST api/booking
		// get post from client
		$json = file_get_contents('php://input');
		$post = json_decode($json); // decode to object

		// check input completeness
		if($post->customer=="" || $post->status==""  || $post->total=="" || $post->pickup==""){
			$response['status'] = 400;
			$response['data'] = array('error' => 'Required data not present!');
		}else{
			$status = $booking->insertBooking($post->customer, $post->driver, $post->status, $post->total, $post->pickup);
			if($status==1){
				$response['status'] = 201;
				$response['data'] = array('success' => 'Booking Added successfully!');
			}else{
				$response['status'] = 400;
				$response['data'] = array('error' => 'Booking Add failed!');
			}
		}
	}
	elseif($method=='PUT'){
		// METHOD : PUT api/barang/:id
		if(isset($url_array[1])){
			$id = $url_array[1];
			// check if id exist in database
			$data=$booking->getBooking($id);
			if(empty($data)) { 
				$response['status'] = 404;
				$response['data'] = array('error' => 'Invalid Booking!');	
			}else{
				// get post from client
				$json = file_get_contents('php://input');
				$post = json_decode($json); // decode to object

				// check input completeness
				if($post->driver=="" || $post->status=="" ){
					$response['status'] = 400;
					$response['data'] = array('error' => 'Required Data Missing! ');
				}else{
					$status = $booking->updateBooking($id, $post->driver, $post->status, $post->status);
					if($status==1){
						$response['status'] = 200;
						$response['data'] = array('success' => 'Successfully updated the booking!');
					}else{
						$response['status'] = 400;
						$response['data'] = array('error' => 'Something went wrong!');
					}
				}
			}
		}
	}
	elseif($method=='DELETE'){
		// METHOD : DELETE api/barang/:idBarang
		if(isset($url_array[1])){
			$id = $url_array[1];
			// check if idBarang exist in database
			$data=$barang->getBooking($id);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Invalid Booking!');	
			}else{
				$status = $barang->deleteBooking($id);
				if($status==1){
					$response['status'] = 200;
					$response['data'] = array('success' => 'Booking deleted successfuly');
				}else{
					$response['status'] = 400;
					$response['data'] = array('error' => 'Something Went Wrong!');
				}
			}
		}
	}
}


// system user
if( strcasecmp($action,'sysuser') == 0){
	$user = new Sysuser();
	if($method=='GET'){
		if(!isset($url_array[1]) ){ // if parameter idBarang not exist
			
			$data=$user->getAllUsers();
			$response['status'] = 200;
			$response['data'] = $data;
		}else{ 
			
			if(!isset($url_array[2]) && isset($url_array[1]) ){
				$data=$user->getUser($url_array[1]);
				if(empty($data)) {
					$response['status'] = 404;
					$response['data'] = array('error' => 'No Data!');	
				}else{
					$response['status'] = 200;
					$response['data'] = $data;	
				}
			}
			else{

			$userid=$url_array[1];
			$password=$url_array[2];
			$data=$user->getUserLogin($userid,$password);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'Wrong Credentials!');	
			}else{
				$response['status'] = 200;
				$response['data'] = $data;	
			}
		}
		}
	}
	elseif($method=='POST'){
		
	}
	elseif($method=='PUT'){
		
		//if(isset($url_array[1])){
			
			// check if idBarang exist in database
			
				// get post from client
				$json = file_get_contents('php://input');
				$post = json_decode($json); // decode to object

				// check input completeness
				if($post->fname=="" || $post->contact=="" || $post->mail==""  || $post->address=="" || $post->id=="" ){
					$response['status'] = 400;
					$response['data'] = array('error' => 'Missing Required Data');
				}else{
					$status = $user->updateCustomer($post->fname, $post->address, $post->pwd, $post->mail, $post->contact, $post->id, $post->uname );
					if($status==1){
						$response['status'] = 200;
						$response['data'] = array('success' => 'User Updated Successfully!');
					}else{
						$response['status'] = 400;
						$response['data'] = array('error' => 'Something Went Wrong!');
					}
				}
	}
	elseif($method=='DELETE'){
		// METHOD : DELETE api/barang/:idBarang
		if(isset($url_array[1])){
			$idBarang = $url_array[1];
			// check if idBarang exist in database
			$data=$barang->getBarang($idBarang);
			if(empty($data)) {
				$response['status'] = 404;
				$response['data'] = array('error' => 'No User');	
			}else{
				$status = $barang->deleteBarang($idBarang);
				if($status==1){
					$response['status'] = 200;
					$response['data'] = array('success' => 'Deleted success!');
				}else{
					$response['status'] = 400;
					$response['data'] = array('error' => 'Something Went Wrong!');
				}
			}
		}
	}
}



// Return Response to browser
deliver_response($response);

?>