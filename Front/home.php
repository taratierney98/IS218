<?php session_start(); //Start session inorder to display the saved first and last name of the user
?>

<!DOCTYPE html>
<html>
<head>
<style>
body { 
	font-family: Arial, Helvetica, sans-serif; 
	color: black; 
	background: url(background3.jpg);  
	background-repeat: no-repeat;   
	background-size: cover;
	<!--- background-position: center; --->
}

.header { 
	padding: 10px; 
	text-align: center; 
	background-color: white; 
	opacity: 0.7;
}

.column { 
	float: left; 
	width: 50%; 
	min-height: 350px;
}

.row { 
	background-color: white; 
	opacity: 0.7;
	min-height: 435px;
}

.row:after { 
	content: ""; 
	display: table; 
	clear: both; <!-- Clear floats after the columns -->
} 

.taskInfo { padding: 10px; }

.footer { 
	text-align: center; 
	background-color: white; 
	opacity: 0.7;
}

.btn { 
	color: white; 
	opacity: 0.9; 
	color: white; 
	margin: 3px;
}
	
.btn:hover { opacity: 1; }

.editBtn { background-color: green; }

.deleteBtn { background-color: red; }

.completedBtn { background-color: blue; }

.notcompletedBtn { background-color: blue; }

.newBtn {
	background-color: black; 
	padding: 5px 20px;
}

.signOutBtn { 
	margin: 10px; 
	padding: 5px 30px; 
	font: 15px/20px Arial, sans-serif; 
	background-color: blue;
}

.t { 
	border: 3px solid #f1f1f1;  
	margin-right: 4%; 
	margin-left: 4%; 
	padding: 1%; 
	text-align: left;
}

hr { border: 1px solid #f1f1f1; }

.noTasks { text-align: center; }


</style>
</head>
<body onload="getTasks()">

<div class="header">
	<h2>
	<?php
	// Barrier code to check that the user is logged in
	if( !isset($_SESSION["logged-in"]) )
	{
		// If the user is not logged-in, redirect them back to the login page
		print "<br> You must login first <br><br>";
		header("refresh:2,  url = login.html");
		exit();
	}
	// If the user is logged-in, display their first and last name at the top of the page
	$fn = $_SESSION['fname']; $ln = $_SESSION['lname'];
	print "Hello $fn $ln, here are your tasks:";
	?></h2><hr>
</div>

<div id="msg"></div>

<div class="row">
	<div class="column">
		<center><h3>Incomplete Tasks</h3><input type=button id="makeNew" class="newBtn btn" value="New"></center>
		<div id="incompleteTasks" class="taskInfo"></div>
	</div>

	<div class="column">
		<center><h3>Completed Tasks</h3></center> <br><br>
		<div id="completeTasks" class="taskInfo"></div>
	</div>
</div>

<div class="footer">
  	<center>
		<input type=button id="logout"  class="signOutBtn btn" value="Sign out"> <br><br>
	<center>
</div>

</body>
</html>

<script>

var ptrLogout = document.getElementById("logout");
	ptrLogout.addEventListener("click",logOut);

var ptrMakeNew = document.getElementById("makeNew");
	ptrMakeNew.addEventListener("click",makeNewTask);
	
// User has pressed the logout button
function logOut()
{	
	window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/logout.php"; 
}

// When the page loads, make requests to the backend for the task data
function getTasks()
{
	// Request the incomplete task information and display it on the page
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			var response = this.responseText;	
			if(response == "")
			{
				document.getElementById("incompleteTasks").innerHTML = "<br><p class='noTasks'><b>No incompleted tasks.</b></p>";
			}
			else
			{
				document.getElementById("incompleteTasks").innerHTML = response;		
			}		
		}	
	};
	request.open("POST", "getITasks.php", true);
	request.send();	
	
	// Request the completed task information and display it on the page
	var request2 = new XMLHttpRequest();
	request2.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			var response2 = this.responseText;	
			if(response2 == "")
			{
				document.getElementById("completeTasks").innerHTML = "<br><p class='noTasks'><b>No completed tasks.</b></p>";
			}
			else
			{
				document.getElementById("completeTasks").innerHTML = response2;		
			}		
		}	
	};
	request2.open("POST", "getCTasks.php", true);
	request2.send();	
} 

// The user has pressed the "New" button, so redirect them to the make new task page
function makeNewTask()
{
	window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/makeNewTask.php"; 
}	

// User pressed the delete button for a specific task
function deleteBtnPress(clicked)
{
	var tId = clicked.substring(6); 
	makeChange(tId, "delete");
}	

// User pressed the completed button for a specific task
function markAsComplete(clicked)
{
	var tId = clicked.substring(8);
	makeChange(tId, "complete");
}

// User pressed the un-complete button for a specific task
function markAsUncomplete(clicked)
{
	var tId = clicked.substring(10);
	makeChange(tId, "uncomplete");
}

// User pressed the edit button for a specific task
function editBtnPress(clicked)
{
	var tId = clicked.substring(4);
	makeChange(tId, "edit");
}

// The user has pressed the delete, edit, complete, or uncomplete buttons
// Make a note of the operation (delete, edit, complete, or uncomplete) and task id and 
// send this information to the backend so the database can be updated accordingly
function makeChange(taskId, operation)
{	
	
	var request3 = new XMLHttpRequest();
	request3.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			var response3 = this.responseText; // Here for testing purposes
			//document.getElementById("msg").innerHTML = response3;	
			
			// Reload the page or redirect the user to the edit page depending on which button was pressed
			if(operation == "edit")
				window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/editTask.php"; 	
			else
				window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/home.php"; 	
		}	
	};
	request3.open("POST", "https://web.njit.edu/~tat22/IS218/Project2/Front/sendChangeRequest.php", true);
	request3.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
	request3.send("id="+encodeURIComponent(taskId)+"&operation="+encodeURIComponent(operation));
}

</script>