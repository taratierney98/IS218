<?php

// FOR THE GIVEN TASK, MARK IT COMPLETE OR INCOMPLETE, DELETE IT, OR EDIT IT
// THE TASK INFO WILL TEMPORARILY BE STORED IN THE editTodo TABLE

//---receive the id of the task to be changed and the operation to be performed---
$data = file_get_contents('php://input');
$json = json_decode($data);
$taskId = $json->{'id'};
$operation = $json->{'operation'};


//---database credentials---
$servername = "sql1.njit.edu";
$un = "tat22";
$pw = "YhwiKlZf";
$dbname = "tat22"; 

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $un, $pw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//-----------------------------------------------------------------------------
	
	//--- mark task complete ---
	if($operation == "complete"){
		$query = "UPDATE todos SET isDone = 'T' WHERE taskId = $taskId";
		$statement = $conn->prepare($query);
		$statement->execute();
		$statement->closeCursor();
	}
	
	//--- mark task uncomplete ---
	if($operation == "uncomplete"){
		$query = "UPDATE todos SET isDone = 'F' WHERE taskId = $taskId";
		$statement = $conn->prepare($query);
		$statement->execute();
		$statement->closeCursor();
	}
	
	//--- delete task ---
	if($operation == "delete"){
		$query = "DELETE FROM todos WHERE taskId = $taskId";
		$statement = $conn->prepare($query);
		$statement->execute();
		$statement->closeCursor();
	}
	
	//---- transfer task into editTodos table ---
	if($operation == "edit"){
		$query = "SELECT ownerEmail, title, description, createDate, dueDate, isDone FROM todos 
					WHERE taskId = $taskId";
		$statement = $conn->prepare($query);
		$statement->execute();
		$result = $statement->fetch();
		$statement->closeCursor();
		
		$oe = $result['ownerEmail'];
		$t = $result['title'];
		$d = $result['description'];
		$cd = $result['createDate'];
		$dd = $result['dueDate'];
		$id = $result['isDone'];
		
		$t = str_replace('\'','\\\'',$t);
		$d = str_replace('\'','\\\'',$d);
		
		$query2 = "INSERT INTO editTodo (taskId, ownerEmail, title, description, createDate, dueDate, isDone)
						VALUES ($taskId, '$oe', '$t', '$d', '$cd', '$dd', '$id')";
		print $query2;				
		$statement2 = $conn->prepare($query2);
		$statement2->execute();
		$statement2->closeCursor();
	}				
}
	
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>