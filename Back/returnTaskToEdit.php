<?php

// RETURN THE TASK INFO TEMPORARILY BEING STORED IN THE editTodo TABLE
// THIS INFO WILL BE DISPLAYED AND OPENED TO EDITING IN A NEW FRONT END PAGE

//---database credentials---
$servername = "sql1.njit.edu";
$un = "tat22";
$pw = "YhwiKlZf";
$dbname = "tat22"; 

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $un, $pw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//-----------------------------------------------------------------------------
	
	//---return info from the only row in the editTodo table, empty the table---
	$query = "SELECT taskId, title, description, dueDate FROM editTodo";
	$statement = $conn->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
		
	$tid = $result['taskId'];
	$t = $result['title'];
	$d = $result['description'];
	$dd = $result['dueDate'];
		
	$jstring .= "[{\"taskId\":\"$tid\",\"title\":\"$t\",\"description\":\"$d\",\"dueDate\":\"$dd\"}]";	
	print $jstring;	
	
	$query2 = "DELETE FROM editTodo";
	$statement2 = $conn->prepare($query2);
	$statement2->execute();
	$statement2->closeCursor();
}

catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>