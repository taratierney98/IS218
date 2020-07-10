<?php

// RETURN THE INCOMPLETED TASKS IN THE todos TABLE FOR THE CURRENT USER

//---receive user's email/username from front end---
$data = file_get_contents('php://input');
$json = json_decode($data);
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

	$query = "SELECT taskId, title, description, createDate, dueDate FROM todos WHERE ownerEmail = '$email' and isDone = 'F' ORDER BY dueDate ASC";
	$statement = $conn->prepare($query);
	$statement->execute();
	$results = $statement->fetchAll();
	$statement->closeCursor();
		
	$jstring = "[";
	foreach($results as $result){
		$tid = $result['taskId'];
		$t = $result['title'];
		$d = $result['description'];
		$cd = $result['createDate'];
		$dd = $result['dueDate'];

		$jstring .= "{\"taskId\":\"$tid\",\"title\":\"$t\",\"description\":\"$d\",\"createDate\":\"$cd\",\"dueDate\":\"$dd\"},";
	}
	$jstring = substr($jstring,0,-1);
	$jstring .= "]";
	print $jstring;
}

catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>