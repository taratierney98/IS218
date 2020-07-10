<?php

// ADD A NEW TASK TO THE todos TABLE

//---receive new task info from front end---
$data = file_get_contents('php://input');
$json = json_decode($data);

$title = $json->{'title'};
$desc = $json->{'description'};
$date = $json->{'date'};
$time = $json->{'time'};
$email = $json->{'username'};

//---database credentials---
$servername = "sql1.njit.edu";
$un = "tat22";
$pw = "YhwiKlZf";
$dbname = "tat22"; 

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $un, $pw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//-----------------------------------------------------------------------------
	
	//---determine the taskId for the new task---
	$query = "SELECT MAX(taskId) FROM todos";
	$statement = $conn->prepare($query);
	$statement->execute();
	$results = $statement->fetch();
	$statement->closeCursor();
	
	$max_id = $results[0];
	$newId = $max_id+1;
	
	$created = date("Y-m-d H:i:s"); //---determine create date automatically----
	$due = $date." ".$time;	
	
	$title = str_replace('\'','\\\'',$title);
	$desc = str_replace('\'','\\\'',$desc);
	
	$query2 = "INSERT INTO todos (taskId, ownerEmail, title, description, createDate, dueDate, isDone)
				VALUES ($newId, '$email', '$title', '$desc', '$created', '$due', 'F')";
	$statement2 = $conn->prepare($query2);
	$statement2->execute();
	$statement2->closeCursor();
}

catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>