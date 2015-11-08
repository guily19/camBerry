<?php
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
// $conn = new mysqli($servername, $username, $password);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 
// echo "Connected successfully";

class User {
	var $email;
	var $name;
	var $personalCameras = [];
	var $password;

	function User ($email, $name, $password, $personalCameras){
		$this->email = $email;
		$this->name = $name;
		$this->personalCameras = $personalCameras;
	}

	function isRegistered ($email){
		$conn = new mysqli($servername, $username, $password);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		echo "Connected successfully";
		$query = "SELECT count(name) FROM users WHERE email == "$email" ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	function getName ($email){
		$conn = new mysqli($servername, $username, $password);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		echo "Connected successfully";
		$query = "SELECT name FROM users WHERE email == "$email" ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
        		echo "Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        		$name = $row["firstname"]. " " . $row["lastname"];
    		}
    		return $name;
		}
		return undefined;
	}

	function getPersonalCameras ($email) {

	}

	function getOtherCameras ($email){

	}

}
?>