<?php
session_start();
// Retrieve the username from the sessions array
$username = $_SESSION["username"];

$u = "{\"username\":\"$username\"}";

// Send the user's username to the backend and recieve that user's incomplete task data
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/IS218/Project2/Back/returnITasks.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $u);
$recieved = curl_exec($ch);
curl_close($ch);

// Analyzed the recieved data
if($recieved == "")
{
	print "";
}
else
{
	// Format the incomplete tasks data and send it back to home.php to be displayed
	$q = JSON_decode($recieved, true);
	foreach($q as $item)
	{
		$output = "";
		
		$id = $item["taskId"]; $title = $item["title"]; $description = $item["description"];
		$createDate = $item["createDate"]; $dueDate = $item["dueDate"];
		
		$createDateS = date("F j, Y, g:i a", strtotime($createDate));
		$dueDateS = date("F j, Y, g:i a", strtotime($dueDate));
			
		$output .=  "<div class='t' id='$id'> <b>Title:</b> $title <br> <b>Description:</b> $description <br>".
					"<b>Create date:</b> $createDateS <br> <b>Due date:</b> $dueDateS<br>" .
					"<input type=button id='complete$id' class='completedBtn btn'   value='Mark Complete' onClick=\"markAsComplete(this.id)\">" .
					"<input type=button id='edit$id' class='editBtn btn'  value='Edit' onClick=\"editBtnPress(this.id)\">" . 
					"<input type=button id='delete$id' class='deleteBtn btn'  value='Delete' onClick=\"deleteBtnPress(this.id)\"></div><br>";
			
		print $output;
	}	
}

?>