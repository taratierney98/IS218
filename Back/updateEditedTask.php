<?php

// UPDATE THE todos TABLE WITH THE UPDATED INFORMATION

//---receive updated task info from front end---
$data = file_get_contents('php://input');
$json = json_decode($data);

$tid = $json->{'tid'};
$title = $json->{'title'};
$desc = $json->{'description'};

$d = $json->{'date'};
$t = $json->{'time'};
$date = $d." ".$t;

//---database credentials---
$servername = "sql1.njit.edu";
$un = "tat22";
$pw = "YhwiKlZf";
$dbname = "tat22"; 

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $un, $pw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//-----------------------------------------------------------------------------
	
	$title = str_replace('\'','\\\'',$title);
	$desc = str_replace('\'','\\\'',$desc);
	
	$query = "UPDATE todos SET title = '$title', description = '$desc', dueDate = '$date' WHERE taskId = $tid";
	$statement = $conn->prepare($query);
	$statement->execute();
	$statement->closeCursor();		
}
	
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>