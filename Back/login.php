<?php

// LOGIN

//---receive login credentials from front end---
$data = file_get_contents('php://input');
$json = json_decode($data);

$username = $json->{'username'};
$password = $json->{'password'};

//---database credentials---
$servername = "sql1.njit.edu";
$un = "tat22";
$pw = "YhwiKlZf";
$dbname = "tat22"; 

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $un, $pw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//-----------------------------------------------------------------------------
		
	$query = "SELECT password, fname, lname FROM accounts WHERE email = '$username'";
	$statement = $conn->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	
	$pass = $results['password'];
	$fn = $results['fname'];
	$ln = $results['lname'];
	

	if($pass == $password)
		$status = "T";
	else
		$status = "F";

	//---return "T" or "F" to front end to signfiy if the login was successful or not---
	//---return the user's first name & last name for the front end to save in the session array--
	$login_array = array('login' => $status, 'fname' => $fn, 'lname' => $ln);
	$login_return = json_encode($login_array);
	print $login_return; 
}

catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>