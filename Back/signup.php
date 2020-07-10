<?php

// SIGNUP

//---receive signup credentials from front end---
$email = $_POST["username"];
$password = $_POST["password"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$college = $_POST["college"];
$major = $_POST["major"];
 
//---database credentials---
$servername = "sql1.njit.edu";
$un = "tat22";
$pw = "YhwiKlZf";
$dbname = "tat22"; 

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $un, $pw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//-----------------------------------------------------------------------------
	
	//---determine the id for the new user---
	$query = "SELECT MAX(id) FROM accounts";
	$statement = $conn->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	
	$max_id = $results[0];
	$newId = $max_id+1;
	
	$query2 = "INSERT INTO accounts (id, email, password, fname, lname, college, major)
				VALUES ($newId, '$email', '$password', '$fname', '$lname', '$college', '$major')";
	$statement2 = $conn->prepare($query2);
	$statement2->execute();
	$statement2->closeCursor();
}

catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>