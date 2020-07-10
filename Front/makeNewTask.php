<?php session_start();?>

<!DOCTYPE html>
<meta charset = "UTF-8">
		
<html>

<head>
<style>
body { font-family: Arial, Helvetica, sans-serif; color: black; 
       background-image: url("background.jpg");  background-repeat: no-repeat;   background-size: cover;}
		
form { width:55%;  margin: auto; border:5px solid #f1f1f1; padding: 15px; background-color: white; opacity: 0.8; }

input[type=text] 
{ width: 95%; padding: 10px; margin: 5px 0 20px 0; display: inline-block; border: none; background: #f1f1f1;}

textarea { width: 95%; padding: 10px; border: none; background: #f1f1f1; font-family: inherit;}

hr { border: 1px solid #f1f1f1;}

.btn { display: inline-block; position: relative; margin: 10px; padding: 5px 30px; text-align: center; 
	   font: 15px/20px Arial, sans-serif; background-color: blue; color: white;   opacity: 0.8;}	

.btn:hover { opacity: 1;}

#subMsg{color: blue;}

</style>
</head>

<body>
	<br> 

	<form id='myform' action="sendNewTask.php" method="post">

		<?php
		// Barrier code to check that the user is logged in
		if( !isset($_SESSION["logged-in"]) )
		{
			print "<br> You must login first <br><br>";
			header("refresh:2,  url = login.html");
			exit();
		}	
		?>
		
		<center> <h2> New Task Creation </h2> </center> <hr>
						
		<div id="subMsg"></div>
						
		<br><label for="title"> <b> Title </b> </label>	<br>		
		<input type=text id="title" placeholder="Enter task title" autocomplete="off"  width="100%"><br>				
				
		<label for="des"> <b> Description </b> </label> <br>			
		<textarea id="des" placeholder="Enter task description" rows="2" id="des" maxlength="144"></textarea> <br><br>
			
		<label for="date"> <b> Due Date and Time </b> </label> <br>	
		<input type="date" id="date"> <input type="time" id="time">
			
		<br><br><br><br><br><br><br><br>
		<center><input type=button id="subT" class="btn" value="Submit"></center>		
	
	</form>
		
	<center>
		<input type=button id="returnHome" class="btn" value="Return to Home Page">
		<input type=button id="logout" class="btn" value="Sign Out">
	</center>
		 
</body>	
</html> 

<script>

var ptrTitle = document.getElementById("title");
var ptrDes = document.getElementById("des");
var ptrDate = document.getElementById("date");
var ptrTime = document.getElementById("time");

var ptrRH = document.getElementById("returnHome");
	ptrRH.addEventListener("click",returnHome);
	
var ptrLogout = document.getElementById("logout");
	ptrLogout.addEventListener("click",logOut);
	
var ptrSub = document.getElementById("subT");
	ptrSub.addEventListener("click", sendTask);

// User has pressed the "return to home page" button
// If a new task was created, the home page will be updated to show it
function returnHome()
{
	window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/home.php"; 
}
	
// User has pressed the "sign out" button
function logOut()
{	
	window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/logout.php"; 
}

// Send the new task information to the backend
function sendTask()
{
	var title = ptrTitle.value;
	var des = ptrDes.value;
	var date = ptrDate.value;
	var time = ptrTime.value;
	
	// Check to see that all inputs have entered values. If not, notify the user
	if(title == "" || des == "" || date == "" || time == "")
	{
		document.getElementById("subMsg").innerHTML = "<center>Please fill out all fields.</center>";
	}
	else
	{
		// Clear any previous notifications in regards to missing input
		document.getElementById("subMsg").innerHTML = "";
		
		var request = new XMLHttpRequest();
		request.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				var response = this.responseText; // Only used for testing purposes			
				
				document.getElementById('myform').innerHTML = "<center>New task successfully added!</center>";	
					
			}
		};
		request.open("POST", "https://web.njit.edu/~tat22/IS218/Project2/Front/sendNewTask.php", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		request.send("title="+encodeURIComponent(title)+"&des="+encodeURIComponent(des)+"&date="+encodeURIComponent(date)+"&time="+encodeURIComponent(time));
	}	
}
</script>