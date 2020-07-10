<?php session_start(); ?>

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

<body onload="getTask()">
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
		
		<center> <h2> Edit Task </h2> </center> <hr><br>
		
		<div id="subMsg"></div>
		<div id="task">
		
			<input type=hidden id="tid" value="">
			
			<label for="title"> <b> Title </b> </label> <br>	
			<input type=text id="title" value="" autocomplete="off"  width="100%"><br>	
			
			<label for="des"> <b> Description </b> </label> <br>
			<textarea id="des" id="des" maxlength='144'></textarea> <br><br>
			
			<label for="date"> <b> Due Date and Time </b> </label> <br>
			<input type="date" id="date" value=""> <input type="time" id="time" value="">
		
		</div>	
		
		<br><br><br><br><br><br><br><br>
		<center><input type=button id="subT" class="btn" value='Submit'></center>		
	
	</form>
		
	<center>
		<input type=button id="returnHome" class="btn" value="Return to Home Page">
		<input type=button id="logout" class="btn" value="Sign Out">
	</center>
		 
</body>	
</html> 

<script>
var ptrLogout = document.getElementById("logout");
	ptrLogout.addEventListener("click",logOut);
	
var ptrRH = document.getElementById("returnHome");
	ptrRH.addEventListener("click",returnHome);	
	
var ptrSub = document.getElementById("subT");
	ptrSub.addEventListener("click", sendTask);	
	
var ptrTID = document.getElementById("tid");
var ptrTitle = document.getElementById("title");
var ptrDes = document.getElementById("des");
var ptrDate = document.getElementById("date");
var ptrTime = document.getElementById("time");
	
// When the page is loaded, get the task that was selected to be editied, and display its current information
function getTask()
{
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			// Recieve task information as a JSON string
			var response = this.responseText;	
			
			if(response == "")
			{
				document.getElementById("subMsg").innerHTML = "Could not retrieve task.";
			}
			else
			{
				var r = response.substring(1, response.length-1);
				
				// Parse the JSON string and extract the task data from it
				var obj = JSON.parse(r);
				
				var id = obj.taskId;
				var title = obj.title;
				var des = obj.description;
				var dueDate = obj.dueDate;
				
				var date_time = dueDate.split(" ");
				var date = date_time[0];
				var time = date_time[1];
								
				//document.getElementById("subMsg").innerHTML = id + " " + title + " " + des + " " + date + " " + time
				
				// Display the task's information in the html input elements
				ptrTID.value = id;
				ptrTitle.value = title;
				ptrDes.value = des;
				ptrDate.value = date;
				ptrTime.value = time;
			}
					
		}	
	};
	request.open("POST", "https://web.njit.edu/~tat22/IS218/Project2/Front/getTaskToEdit.php", true);
	request.send();	
}

// When the submit button is pressed, check that all input fields have data in them
// and then send that data to the back end so the task can be updated
function sendTask()
{
  //alert("here");
	var id = ptrTID.value;
	var title = ptrTitle.value;
	var des = ptrDes.value;
	var date = ptrDate.value;
	var time = ptrTime.value;
	
	if(title == "" || des == "" || date == "" || time == "")
	{
		document.getElementById("subMsg").innerHTML = "<center>Please fill out all fields.</center>";
	}
	else
	{
		// Clear any previous "missing data" messages 
		document.getElementById("subMsg").innerHTML = "";
		
		// Send the task info and update the current page
		var request = new XMLHttpRequest();
		request.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				var response = this.responseText;				
				document.getElementById('myform').innerHTML = "<center>Task successfully updated!</center>";	
			}
		};
		request.open("POST", "https://web.njit.edu/~tat22/IS218/Project2/Front/sendEditedTask.php", true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		request.send("id="+encodeURIComponent(id)+"&title="+encodeURIComponent(title)+"&des="+encodeURIComponent(des)+"&date="+encodeURIComponent(date)+"&time="+encodeURIComponent(time));
	}	
}

// User pressed the "Sign Out" button
function logOut()
{	
	window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/logout.php"; 
}

// User pressed the "Return to home page" button
function returnHome()
{
	window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/home.php"; 
}
	
</script>